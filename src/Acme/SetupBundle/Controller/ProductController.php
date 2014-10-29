<?php

namespace Acme\SetupBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\SetupBundle\Entity\Product;
use Acme\SetupBundle\Form\ProductType;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{

    /**
     * Lists all Product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeSetupBundle:Product')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1) /*page number*/,
            10
        /*limit per page*/
        );

        return $this->render(
            'AcmeSetupBundle:Product:index.html.twig',
            array(
                'entities' => $entities,
            )
        );
    }

    /**
     * Creates a new Product entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Product();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($entity->file != null) {
                $entity->setImage(uniqid().'.'.$entity->file->guessExtension());
                $entity->file->move($entity->getUploadRootDir(), $entity->getImage());
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('product_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'AcmeSetupBundle:Product:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Creates a form to create a Product entity.
     *
     * @param Product $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Product $entity)
    {
        $form = $this->createForm(
            new ProductType(),
            $entity,
            array(
                'action' => $this->generateUrl('product_create'),
                'method' => 'POST',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Save'));

        return $form;
    }

    /**
     * Displays a form to create a new Product entity.
     *
     */
    public function newAction()
    {
        $entity = new Product();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'AcmeSetupBundle:Product:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Finds and displays a Product entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSetupBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AcmeSetupBundle:Product:show.html.twig',
            array(
                'entity' => $entity,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSetupBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'AcmeSetupBundle:Product:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Creates a form to edit a Product entity.
     *
     * @param Product $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Product $entity)
    {
        $form = $this->createForm(
            new ProductType(),
            $entity,
            array(
                'action' => $this->generateUrl('product_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Product entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSetupBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ($entity->file != null) {
                $entity->setImage(uniqid().'.'.$entity->file->guessExtension());
                $entity->file->move($entity->getUploadRootDir(), $entity->getImage());
            }
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'heads_up',
                "Your change was successfully saved."
            );

            return $this->redirect($this->generateUrl('product_edit', array('id' => $id)));
        }

        return $this->render(
            'AcmeSetupBundle:Product:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Deletes a Product entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmeSetupBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
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
        $this->get('session')->getFlashBag()->add('oh_snap', 'Product was successfully deleted.');

        //return $this->redirect($this->get('request')->server->get('HTTP_REFERER'));
        return $this->redirect($this->generateUrl('product'));
    }

    /**
     * Creates a form to delete a Product entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
