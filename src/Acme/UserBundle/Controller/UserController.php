<?php

namespace Acme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Acme\UserBundle\Entity\User;
use Acme\UserBundle\Form\UserType;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Acme\UserBundle\Form\SearchType;

/**
 * User controller.
 *
 */
class UserController extends Controller
{

    /**
     * Lists all User entities.
     *
     */
    public function indexAction($page)
    {
        $userManager = $this->get('fos_user.user_manager');
        $searchedUser = $userManager->findUsers();

        $adapter = new ArrayAdapter($searchedUser);
        $pagerUser = new Pagerfanta($adapter);
        $pagerUser->setMaxPerPage($this->get('service_container')->getParameter('pager_max_per_page'));

        try {
            $pagerUser->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            return $this->render('AcmeDashBundle:Error:PageNotFound.html.twig', array('pageNumber' => $page));
        }

        $searchForm = $this->createForm(new SearchType('Acme\UserBundle\Entity\User'), null);

        return $this->render(
            'AcmeUserBundle:User:index.html.twig',
            array(
                'entities' => $pagerUser,
                'searchForm' => $searchForm->createView()
            )
        );
    }

    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $user = $this->get('security.context')->getToken()->getUser();

        if ($form->isValid()) {
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
            $password = $encoder->encodePassword($entity->getUsername(), $entity->getSalt());
            $entity->setPassword($password);
            $entity->setCreatedBy($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'AcmeUserBundle:User:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(
            new UserType($this->getRoles()),
            $entity,
            array(
                'action' => $this->generateUrl('user_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Save'));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'AcmeUserBundle:User:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AcmeUserBundle:User:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AcmeUserBundle:User:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(
            new UserType($this->getRoles()),
            $entity,
            array(
                'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Save'));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
            $password = $encoder->encodePassword($entity->getUsername(), $entity->getSalt());
            $entity->setPassword($password);
            if ($entity->file != null) {
                $entity->setImage(uniqid() . '.' . $entity->file->guessExtension());
                $entity->file->move($entity->getUploadRootDir(), $entity->getImage());
            }
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'heads_up',
                "Your change was successfully saved."
            );

            return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
        }

        return $this->render(
            'AcmeUserBundle:User:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmeUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        try {
            $em->remove($entity);
            $em->flush();
        } catch (\Exception $e) {
            $this->get('session')->getFlashBag()->set('oh_snap', $this->container->getParameter('used_error_long'));

            return $this->redirect($this->get('request')->server->get('HTTP_REFERER'));
        }
        $this->get('session')->getFlashBag()->add('well_done', 'User was successfully deleted.');

        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    protected function getRoles()
    {
        $roles = array();

        foreach ($this->container->getParameter('security.role_hierarchy.roles') as $name => $rolesHierarchy) {
            $roles[$name] = $name;

            foreach ($rolesHierarchy as $role) {
                if (!isset($roles[$role])) {
                    $roles[$role] = $role;
                }
            }
        }

        return $roles;
    }


    public function findUsernameAction(Request $request,$page)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $username = $request->request->get('acme_userbundle_search')['username'];

        if ($username == null or $username == ' ') {
            return $this->redirect($this->generateUrl('user'));
        }

        $searchedUser = $em->getRepository('AcmeUserBundle:User')->findUsernameResult($username);

        $adapter = new ArrayAdapter($searchedUser);
        $pagerUser = new Pagerfanta($adapter);
        $pagerUser->setMaxPerPage($this->get('service_container')->getParameter('pager_max_per_page'));

        try {
            $pagerUser->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            return $this->render('AcmeDashBundle:Error:PageNotFound.html.twig', array('pageNumber' => $page));
        }

        $searchForm = $this->createForm(new SearchType('Acme\UserBundle\Entity\User'), null);

        return $this->render(
            'AcmeUserBundle:User:index.html.twig',
            array(
                'entities' => $pagerUser,
                'filter' => $username,
                'searchForm' => $searchForm->createView()
            )
        );
    }
}
