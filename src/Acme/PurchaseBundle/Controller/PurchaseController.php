<?php

namespace Acme\PurchaseBundle\Controller;

use Acme\PurchaseBundle\Entity\PurchaseLine;
use Acme\PurchaseBundle\Form\PurchaseLineType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Acme\PurchaseBundle\Entity\Purchase;
use Acme\PurchaseBundle\Form\PurchaseType;

/**
 * Purchase controller.
 *
 */
class PurchaseController extends Controller
{

    /**
     * Lists all Purchase entities.
     *
     */
    public function indexAction()
    {
        return $this->render('AcmePurchaseBundle:Purchase:index.html.twig');
    }

    public function indexResultsAction()
    {
        $datatable = $this->get('lankit_datatables')->getDatatable('AcmePurchaseBundle:Purchase');
        $datatable->setDefaultJoinType(Datatable::JOIN_LEFT);

        return $datatable->getSearchResults();
    }

    /**
     * Creates a new Purchase entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Purchase();
        $form = $this->createCreateForm($entity);
        $lineForm = $this->createForm(new PurchaseLineType(), new PurchaseLine(), array(
                'method' => 'post',
                'action'=> '#'
            ));
        $form->handleRequest($request);

        $data = $this->get('request')->request->all();
        $data = $data['purchase_line'];

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);

            foreach($data['product'] as $key => $product)
            {
                $line = new PurchaseLine();
                $line->setPurchase($entity);
                $line->setProduct($em->getRepository('AcmeSetupBundle:Product')->find($product));
                $line->setQuantity($data['quantity'][$key]);
                $line->setPrice($data['price'][$key]);
                $em->persist($line);
            }

            $em->flush();

            return $this->redirect($this->generateUrl('purchase_show', array('id' => $entity->getId())));
        }

        return $this->render('AcmePurchaseBundle:Purchase:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'line_form' => $lineForm->createView()
            ));
    }

    /**
     * Creates a form to create a Purchase entity.
     *
     * @param Purchase $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Purchase $entity)
    {
        $form = $this->createForm(new PurchaseType(), $entity, array(
                'action' => $this->generateUrl('purchase_create'),
                'method' => 'POST',
            ));

        return $form;
    }

    /**
     * Displays a form to create a new Purchase entity.
     *
     */
    public function newAction()
    {
        $entity = new Purchase();
        $form   = $this->createCreateForm($entity);
        $lineForm = $this->createForm(new PurchaseLineType(), new PurchaseLine(), array(
                'method' => 'post',
                'action'=> '#'
            ));

        return $this->render('AcmePurchaseBundle:Purchase:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'line_form' =>$lineForm->createView()
            ));
    }

    /**
     * Finds and displays a Purchase entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmePurchaseBundle:Purchase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }
        $lines = $em->getRepository('AcmePurchaseBundle:PurchaseLine')->findBy(
            array('purchase' => $id)
        );

        return $this->render('AcmePurchaseBundle:Purchase:show.html.twig', array(
                'purchase'      => $entity,
                'lines' => $lines,        ));
    }

    /**
     * Displays a form to edit an existing Purchase entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmePurchaseBundle:Purchase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }

        $editForm = $this->createEditForm($entity);
        $lineForm = $this->createForm(new PurchaseLineType(), new PurchaseLine(), array(
                'method' => 'post',
                'action'=> '#'
            ));

        $lines = $em->getRepository('AcmePurchaseBundle:PurchaseLine')->findBy(
            array('purchase' => $id)
        );

        return $this->render('AcmePurchaseBundle:Purchase:edit.html.twig', array(
                'entity'      => $entity,
                'form'   => $editForm->createView(),
                'line_form' => $lineForm->createView(),
                'lines' => $lines
            ));
    }

    /**
     * Creates a form to edit a Purchase entity.
     *
     * @param Purchase $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Purchase $entity)
    {
        $form = $this->createForm(new PurchaseType(), $entity, array(
                'action' => $this->generateUrl('purchase_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            ));

        return $form;
    }
    /**
     * Edits an existing Purchase entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmePurchaseBundle:Purchase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }

        $editForm = $this->createEditForm($entity);
        $lineForm = $this->createForm(new PurchaseLineType(), new PurchaseLine(), array(
                'method' => 'post',
                'action'=> '#'
            ));
        $lines = $em->getRepository('AcmePurchaseBundle:PurchaseLine')->findBy(
            array('purchase' => $id)
        );

        $editForm->handleRequest($request);
        $data = $this->get('request')->request->all();
        $data = $data['purchase_line'];

        if ($editForm->isValid()) {

            if(!empty($data))
            {
                foreach($data['product'] as $key => $product)
                {
                    $line = new PurchaseLine();
                    $line->setPurchase($entity);
                    $line->setProduct($em->getRepository('RaProductBundle:Product')->find($product));
                    $line->setQuantity($data['quantity'][$key]);
                    $em->persist($line);
                }
            }

            $em->flush();

            return $this->redirect($this->generateUrl('purchase_edit', array('id' => $id)));
        }

        return $this->render('AcmePurchaseBundle:Purchase:edit.html.twig', array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'line_form' => $lineForm->createView(),
                'lines' => $lines
            ));
    }
    /**
     * Deletes a Purchase entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmePurchaseBundle:Purchase')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }
        if($entity->getStatus() == 2)
            throw $this->createNotFoundException('Purchase is already finalized');

        $lines = $em->getRepository('AcmePurchaseBundle:PurchaseLine')->findBy(array('purchase' => $entity));
        if(!empty($lines))
            foreach($lines as $line)
                $em->remove($line);

        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('purchase'));
    }

    public function ajaxDeleteLineAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $line = $em->getRepository('AcmePurchaseBundle:PurchaseLine')->find($id);

        if(!$line)
        {
            return new HTTPResponse('Invalid purchase line', 404);
            exit();
        }


        $em->remove($line);
        $em->flush();

        return new HTTPResponse("Successfully deleted.", 200);
    }

}
