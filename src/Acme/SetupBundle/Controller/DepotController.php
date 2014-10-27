<?php

namespace Acme\SetupBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\SetupBundle\Entity\Depot;
use Acme\SetupBundle\Form\DepotType;

/**
 * Depot controller.
 *
 */
class DepotController extends Controller
{

    /**
     * Lists all Depot entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeSetupBundle:Depot')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1) /*page number*/,
            10
        /*limit per page*/
        );

        return $this->render(
            'AcmeSetupBundle:Depot:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Creates a new Depot entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Depot();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('depot_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'AcmeSetupBundle:Depot:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a Depot entity.
     *
     * @param Depot $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Depot $entity)
    {
        $form = $this->createForm(
            new DepotType(),
            $entity,
            array(
                'action' => $this->generateUrl('depot_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Save'));

        return $form;
    }

    /**
     * Displays a form to create a new Depot entity.
     *
     */
    public function newAction()
    {
        $entity = new Depot();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'AcmeSetupBundle:Depot:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Depot entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSetupBundle:Depot')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Depot entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AcmeSetupBundle:Depot:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing Depot entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSetupBundle:Depot')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Depot entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AcmeSetupBundle:Depot:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a Depot entity.
     *
     * @param Depot $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Depot $entity)
    {
        $form = $this->createForm(
            new DepotType(),
            $entity,
            array(
                'action' => $this->generateUrl('depot_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Depot entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSetupBundle:Depot')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Depot entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'heads_up',
                "Your change was successfully saved."
            );

            return $this->redirect($this->generateUrl('depot_edit', array('id' => $id)));
        }

        return $this->render(
            'AcmeSetupBundle:Depot:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Depot entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmeSetupBundle:Depot')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Depot entity.');
        }

        try {
            $em->remove($entity);
            $em->flush();
        } catch (\Exception $e) {
            $this->get('session')->getFlashBag()->set(
                'oh_snap',
                'Error: You can\'t delete this record. You are getting this message because somewhere you already used this record as reference or this record not exist. If you want to know more please contact system administrator.'
            );

            return $this->redirect($this->get('request')->server->get('HTTP_REFERER'));
        }
        $this->get('session')->getFlashBag()->add('oh_snap', 'Depot was successfully deleted.');

        //return $this->redirect($this->get('request')->server->get('HTTP_REFERER'));
        return $this->redirect($this->generateUrl('depot'));
    }

    /**
     * Creates a form to delete a Depot entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('depot_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
