<?php

namespace Acme\EmailBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\EmailBundle\Entity\Email;
use Acme\EmailBundle\Form\EmailType;
use Acme\EmailBundle\Form\SearchType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\ArrayAdapter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Pagerfanta\Exception\NotValidCurrentPageException;


/**
 * Email controller.
 *
 */
class EmailController extends Controller
{

    /**
     * Lists all Email entities.
     *
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $searchedEmail = $em->getRepository('AcmeEmailBundle:Email')->findAll();

        $adapter = new ArrayAdapter($searchedEmail);
        $pagerEmail = new Pagerfanta($adapter);
        $pagerEmail->setMaxPerPage($this->get('service_container')->getParameter('pager_max_per_page'));

        try {
            $pagerEmail->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            return $this->render('AcmeDashBundle:Error:PageNotFound.html.twig', array('pageNumber' => $page));
        }

        $searchForm = $this->createForm(new SearchType('Acme\EmailBundle\Entity\Email'), null);

        return $this->render(
            'AcmeEmailBundle:Email:index.html.twig',
            array(
                'emailEntities' => $pagerEmail,
                'searchForm' => $searchForm->createView()
            )
        );
    }

    /**
     * Creates a new Email entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Email();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $user = $this->container->get('security.context')->getToken()->getUser();

        if ($form->isValid()) {
            $entity->setCreatedBy($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('well_done', 'Email was successfully created.');

            return $this->redirect($this->generateUrl('email'));
        }

        return $this->render(
            'AcmeEmailBundle:Email:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a Email entity.
     *
     * @param Email $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Email $entity)
    {
        $form = $this->createForm(
            new EmailType(),
            $entity,
            array(
                'action' => $this->generateUrl('email_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Email entity.
     *
     */
    public function newAction()
    {
        $entity = new Email();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'AcmeEmailBundle:Email:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Email entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEmailBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AcmeEmailBundle:Email:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing Email entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEmailBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AcmeEmailBundle:Email:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a Email entity.
     *
     * @param Email $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Email $entity)
    {
        $form = $this->createForm(
            new EmailType(),
            $entity,
            array(
                'action' => $this->generateUrl('email_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Email entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeEmailBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'heads_up',
                $this->container->getParameter('update_success')
            );

            return $this->redirect($this->generateUrl('email'));
        }

        return $this->render(
            'AcmeEmailBundle:Email:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Email entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmeEmailBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        try {
            $em->remove($entity);
            $em->flush();
        } catch (\Exception $e) {
            $this->get('session')->getFlashBag()->set('oh_snap', $this->container->getParameter('used_error_long'));

            return $this->redirect($this->get('request')->server->get('HTTP_REFERER'));
        }
        $this->get('session')->getFlashBag()->add('well_done', 'Email was successfully deleted.');

        return $this->redirect($this->generateUrl('email'));
    }

    /**
     * Creates a form to delete a Email entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('email_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    public function findAction(Request $request)
    {
        try {
            $allRequest = $request->createFromGlobals();
            $email = $allRequest->request->get('acme_emailbundle_search')['email'];

            $search = strip_tags(trim($email));

            if ($search == null or $search == ' ') {
                return $this->redirect($this->generateUrl('email'));
            }

            return $this->redirect($this->generateUrl('email_search', array('slug' => $search)));
        } catch (NotFoundHttpException $e) {
            return $this->render('AcmeDashBundle:Error:pageNotFound.html.twig', array('pageNumber' => ''));
        }
    }

    public function searchEmailAction($slug = null, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $searchedEmail = $em->getRepository('AcmeEmailBundle:Email')->searchEmailResult($slug);

        $adapter = new ArrayAdapter($searchedEmail);
        $pagerEmail = new Pagerfanta($adapter);
        $pagerEmail->setMaxPerPage($this->get('service_container')->getParameter('pager_max_per_page'));

        try {
            $pagerEmail->setCurrentPage($page);
        } catch (NotValidCurrentPageException $e) {
            return $this->render('AcmeDashBundle:Error:PageNotFound.html.twig', array('pageNumber' => $page));
        }

        $searchForm = $this->createForm(new SearchType('Acme\EmailBundle\Entity\Email'), null);

        return $this->render(
            'AcmeEmailBundle:Email:index.html.twig',
            array(
                'emailEntities' => $pagerEmail,
                'filter' => $slug,
                'searchForm' => $searchForm->createView()
            )
        );
    }
}
