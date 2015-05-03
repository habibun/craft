<?php

namespace Acme\SetupBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Acme\SetupBundle\Entity\Supplier;
use Acme\SetupBundle\Form\SupplierType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Supplier controller.
 *
 */
class SupplierController extends Controller
{

    /**
     * Lists all Supplier entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT s FROM AcmeSetupBundle:Supplier s";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1),
            $this->container->getParameter('knp_limit_per_page'),
            array(
                'defaultSortFieldName' => 's.name',
                'defaultSortDirection' => 'asc',
            )
        );

        return $this->render('AcmeSetupBundle:Supplier:index.html.twig', array(
            'entities' => $pagination,
        ));
    }

    /**
     * Creates a new Supplier entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $entity = new Supplier();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $entity->setCreatedBy($this->getUser());
            $em->flush();

            return $this->redirect($this->generateUrl('supplier_show', array('id' => $entity->getId())));
        }

        return $this->render('AcmeSetupBundle:Supplier:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Supplier entity.
     *
     * @param Supplier $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Supplier $entity)
    {
        $form = $this->createForm(new SupplierType(), $entity, array(
            'action' => $this->generateUrl('supplier_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        return $form;
    }

    /**
     * Displays a form to create a new Supplier entity.
     *
     */
    public function newAction()
    {
        $entity = new Supplier();
        $form = $this->createCreateForm($entity);

        return $this->render('AcmeSetupBundle:Supplier:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Supplier entity.
     * @param $id
     * @return Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSetupBundle:Supplier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Supplier entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeSetupBundle:Supplier:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Supplier entity.
     * @param $id
     * @return Response
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSetupBundle:Supplier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Supplier entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeSetupBundle:Supplier:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Supplier entity.
     *
     * @param Supplier $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Supplier $entity)
    {
        $form = $this->createForm(new SupplierType(), $entity, array(
            'action' => $this->generateUrl('supplier_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Supplier entity.
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeSetupBundle:Supplier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Supplier entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->
                add('heads_up', "Your change was successfully saved.");

            return $this->redirect($this->generateUrl('supplier_edit', array('id' => $id)));
        }

        return $this->render('AcmeSetupBundle:Supplier:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Supplier entity.
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmeSetupBundle:Supplier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Supplier entity.');
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
        $this->get('session')->getFlashBag()->add('oh_snap', 'Supplier was successfully deleted.');

        return $this->redirect($this->generateUrl('supplier'));
    }

    /**
     * Creates a form to delete a Supplier entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('supplier_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    public function ajaxSupplierListAction(Request $request)
    {
        $get = $request->query->all();

        /* Array of database columns which should be read and sent back to DataTables. Use a space where
        * you want to insert a non-database field (for example a counter or static image)
        */
        $columns = array( 'id', 'name', 'address');
        $get['columns'] = &$columns;

        $em = $this->getDoctrine()->getManager();
        $rResult = $em->getRepository('AcmeSetupBundle:Supplier')->ajaxTable($get, true)->getArrayResult();

        /* Data set length after filtering */
        $iFilteredTotal = count($rResult);

        /*
        * Output
        */
        $output = array(
            //"sEcho" => intval($get['sEcho']),
            "iTotalRecords" => $em->getRepository('AcmeSetupBundle:Supplier')->getCount(),
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        foreach($rResult as $aRow)
        {
            $row = array();
            for ( $i=0 ; $i<count($columns) ; $i++ ){
                if ( $columns[$i] == "version" ){
                    /* Special output formatting for 'version' column */
                    $row[] = ($aRow[ $columns[$i] ]=="0") ? '-' : $aRow[ $columns[$i] ];
                }elseif ( $columns[$i] != ' ' ){
                    /* General output */
                    $row[] = $aRow[ $columns[$i] ];
                }
            }
            $output['aaData'][] = $row;
        }

        unset($rResult);

        return new Response(
            json_encode($output)
        );
    }

    public function supplierListAction()
    {
        return $this->render('AcmeSetupBundle:Supplier:supplierList.html.twig');
    }
}
