<?php

namespace Acme\SetupBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\SetupBundle\Entity\Customer;
use Acme\SetupBundle\Form\CustomerType;

/**
 * Customer controller.
 *
 */
class CustomerController extends Controller
{

    /**
     * Lists all Customer entities.
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT c FROM AcmeSetupBundle:Customer c";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->get('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('AcmeSetupBundle:Customer:index.html.twig', array(
            'entities' => $pagination,
        ));
    }

    /**
     * Creates a new Customer entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entity = new Customer();
        $entity->setCreatedBy($this->getUser());
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('customer_show', array('id' => $entity->getId())));
        }

        return $this->render('AcmeSetupBundle:Customer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Customer entity.
     *
     * @param Customer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Customer $entity)
    {
        $form = $this->createForm(new CustomerType(), $entity, array(
            'action' => $this->generateUrl('customer_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        return $form;
    }

    /**
     * Displays a form to create a new Customer entity.
     *
     */
    public function newAction()
    {
        $entity = new Customer();
        $form   = $this->createCreateForm($entity);

        return $this->render('AcmeSetupBundle:Customer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Customer entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSetupBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeSetupBundle:Customer:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Customer entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSetupBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeSetupBundle:Customer:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Customer entity.
    *
    * @param Customer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Customer $entity)
    {
        $form = $this->createForm(new CustomerType(), $entity, array(
            'action' => $this->generateUrl('customer_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Customer entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSetupBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Customer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('heads_up', $this->container->getParameter('update_success'));
            return $this->redirect($this->generateUrl('customer_edit', array('id' => $id)));
        }

        return $this->render('AcmeSetupBundle:Customer:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmeSetupBundle:Customer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find customer entity.');
        }

        try {
            $em->remove($entity);
            $em->flush();
        } catch (\Exception $e) {
            $this->get('session')->getFlashBag()->set('oh_snap', $this->container->getParameter('used_error_long'));

            return $this->redirect($this->get('request')->server->get('HTTP_REFERER'));
        }

        $this->get('session')->getFlashBag()->add('oh_snap', 'Customer was successfully deleted.');
        return $this->redirect($this->generateUrl('customer'));
    }

    /**
     * Creates a form to delete a Customer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('customer_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
