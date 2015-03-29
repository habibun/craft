<?php

namespace Acme\InvoiceBundle\Controller;

use Acme\InvoiceBundle\Entity\Invoice;
use Acme\InvoiceBundle\Entity\InvoiceLine;
use Acme\InvoiceBundle\Form\InvoiceLineType;
use Acme\InvoiceBundle\Form\InvoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Invoice controller.
 *
 */
class InvoiceController extends Controller
{

    protected $viewData;

    /**
     * Lists all Invoice entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();


        $entities = $em->getRepository('AcmeInvoiceBundle:Invoice')->findAll();


        return $this->render('AcmeInvoiceBundle:Invoice:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Invoice entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Invoice();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $user = $this->container->get('security.context')->getToken()->getUser();

        $data = $this->get('request')->request->all();
        $data = $data['invoice_line'];

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setCreatedBy($user);
            foreach ($data['description'] as $key => $description) {
                $line = new InvoiceLine();
                $line->setInvoice($entity);
                $line->setDescription($data['description'][$key]);
                $line->setUnitPrice($data['unitPrice'][$key]);
                $line->setQuantity($data['quantity'][$key]);
                $em->persist($line);
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('invoice_show', array('id' => $entity->getId())));
        }

        return $this->render('AcmeInvoiceBundle:Invoice:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Invoice entity.
     *
     * @param Invoice $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Invoice $entity)
    {
        $form = $this->createForm(new InvoiceType(), $entity, array(
            'action' => $this->generateUrl('invoice_create'),
            'method' => 'POST',
        ));

        // $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Invoice entity.
     *
     */
    public function newAction()
    {
        $entity = new Invoice();
        $form = $this->createCreateForm($entity);

        $invoiceLine = new InvoiceLine();
        $invoiceLineForm = $this->createForm(
            new InvoiceLineType($this->get('security.context')),
            $invoiceLine,
            array(
                'action' => 'javascript:void(0);',
                'method' => 'POST',
            )
        );
        $this->viewData['form'] = $form->createView();
        $this->viewData['entities'] = $entity;

        return $this->render('AcmeInvoiceBundle:Invoice:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'line_form' => $invoiceLineForm->createView(),
        ));
    }

    /**
     * Finds and displays a Invoice entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeInvoiceBundle:Invoice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Invoice entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeInvoiceBundle:Invoice:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Invoice entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeInvoiceBundle:Invoice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Invoice entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeInvoiceBundle:Invoice:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Invoice entity.
     *
     * @param Invoice $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Invoice $entity)
    {
        $form = $this->createForm(new InvoiceType(), $entity, array(
            'action' => $this->generateUrl('invoice_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Invoice entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeInvoiceBundle:Invoice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Invoice entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('invoice_edit', array('id' => $id)));
        }

        return $this->render('AcmeInvoiceBundle:Invoice:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Invoice entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeInvoiceBundle:Invoice')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Invoice entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('invoice'));
    }

    /**
     * Creates a form to delete a Invoice entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('invoice_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    public function sortAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $order = $request->request->get('order');
            $kind = $request->request->get('kind');

            if (!$order && !$kind) {
                throw $this->createNotFoundException('Unable to find Category entity');
            }

            $entities = $em->getRepository('AcmeInvoiceBundle:Invoice')->getInvoiceAll(
                $this->container->getParameter('max_item_per_page'), null, $kind, $order);

            $entities_return = $this->render('AcmeInvoiceBundle:Invoice:list_invoice_body.html.twig', array(
                'entities' => $entities,
            ))->getContent();
            $result2 = array('entities' => $entities_return, 'success' => true);
            $response = new Response(json_encode($result2));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

    public function moreDetailsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $this->viewData['invoice'] = $em->getRepository('AcmeInvoiceBundle:Invoice')->find($id);
        if (!$this->viewData['invoice']) {
            throw $this->createNotFoundException('Unable to find Invoice entity.');
        }
        $this->viewData['invoiceLine'] = $em->getRepository('AcmeInvoiceBundle:InvoiceLine')->findBy(
            array('invoice' => $this->viewData['invoice'])
        );

        return $this->render('AcmeInvoiceBundle:Invoice:moreDetails.html.twig', $this->viewData);
    }
}
