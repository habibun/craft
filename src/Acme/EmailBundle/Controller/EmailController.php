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

        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT e FROM AcmeEmailBundle:Email e";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1),
            $this->container->getParameter('knp_limit_per_page'),
            array(
                'defaultSortFieldName' => 'e.email',
                'defaultSortDirection' => 'asc',
            )
        );

        $searchForm = $this->createForm(new SearchType('Acme\EmailBundle\Entity\Email'), null);

        return $this->render(
            'AcmeEmailBundle:Email:index.html.twig',
            array(
                'pagerEntities' => $pagerEmail,
                'knpEntities' => $pagination,
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

            return $this->redirect($this->generateUrl('email_show', array('id' => $entity->getId())));
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
            'AcmeEmailBundle:Email:modalNew.html.twig',
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
            'AcmeEmailBundle:Email:modalEdit.html.twig',
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

            return $this->redirect($this->generateUrl('email_edit', array('id' => $id)));
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
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeEmailBundle:Email')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Email entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

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

        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT e FROM AcmeEmailBundle:Email e";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1),
            $this->container->getParameter('knp_limit_per_page'),
            array(
                'defaultSortFieldName' => 'e.email',
                'defaultSortDirection' => 'asc',
            )
        );

        $searchForm = $this->createForm(new SearchType('Acme\EmailBundle\Entity\Email'), null);

        return $this->render(
            'AcmeEmailBundle:Email:index.html.twig',
            array(
                'pagerEntities' => $pagerEmail,
                'knpEntities' => $pagination,
                'filter' => $slug,
                'searchForm' => $searchForm->createView()
            )
        );
    }
}
