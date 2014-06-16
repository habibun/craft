<?php

namespace Acme\PurchaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Acme\PurchaseBundle\Entity\Purchase;
use Acme\PurchaseBundle\Entity\PurchaseLine;
use Acme\PurchaseBundle\Form\PurchaseType;
use Acme\PurchaseBundle\Form\PurchaseLineType;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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
        $em = $this->getDoctrine()->getManager();

        $entity = new Purchase();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $data = $this->get('request')->request->all();
        $data = $data['purchase_line'];

        if ($form->isValid()) {
            $user = $this->getUser();
            $em->persist($entity);
            foreach($data['product'] as $key => $product)
            {
                $line = new PurchaseLine();
                $line->setPurchase($entity);
                $line->setProduct($em->getRepository('AcmeSetupBundle:Product')->findOneById($product));
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
        $form = $this->createForm(new PurchaseType($this->get('security.context')), $entity, array(
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

        $purchaseLine = new PurchaseLine();
        $purchaseLineForm = $this->createForm(new PurchaseLineType($this->get('security.context')), $purchaseLine, array(
                'action' => 'javascript:void(0);',
                'method' => 'POST',
            ));
        $this->viewData['form'] = $form->createView();
        $this->viewData['entities'] = $entity;

        return $this->render('AcmePurchaseBundle:Purchase:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'line_form'   => $purchaseLineForm->createView(),
            ));
    }

    /**
     * Finds and displays a Purchase entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $this->viewData['purchase'] = $em->getRepository('AcmePurchaseBundle:Purchase')->find($id);

        if (!$this->viewData['purchase']) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }

        $this->viewData['purchaseLines'] = $em->getRepository('AcmePurchaseBundle:PurchaseLine')->findBy(array('purchase' => $this->viewData['purchase']));

        return $this->render('AcmePurchaseBundle:Purchase:show.html.twig', $this->viewData);
    }

    /**
     * Displays a form to edit an existing Purchase entity.
     *
     */
    public function editAction($id)
    {
        $this->needCompany();
        $this->needBranch();

        $em = $this->getDoctrine()->getManager();

        $purchase = $em->getRepository('AcmePurchaseBundle:Purchase')->find($id);

        if (!$purchase) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }
        if($this->container->getParameter('statusFinalized') === $purchase->getStatus())
        {
            throw new AccessDeniedException('This is a finalized record. You can\'t modify this');
            exit();
        }

        $editForm = $this->createEditForm($purchase);
        $purchaseLine = new PurchaseLine();
        $lineForm = $this->createForm(new PurchaseLineType($this->get('security.context')), $purchaseLine, array(
                'action' => 'javascript:void(0);',
                'method' => 'POST',
            ));

        $purchaseLines = $em->getRepository('AcmePurchaseBundle:PurchaseLine')->findBy(array('purchase' => $id));

        return $this->render('AcmePurchaseBundle:Purchase:edit.html.twig', array(
                'purchase'      => $purchase,
                'form'   => $editForm->createView(),
                'line_form' => $lineForm->createView(),
                'lines' => $purchaseLines
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
        $form = $this->createForm(new PurchaseType($this->get('security.context')), $entity, array(
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
        $this->needCompany();
        $this->needBranch();

        $em = $this->getDoctrine()->getManager();
        $purchase = $em->getRepository('AcmePurchaseBundle:Purchase')->find($id);

        if (!$purchase) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }
        if($this->container->getParameter('statusFinalized') === $purchase->getStatus())
        {
            throw new AccessDeniedException('This is a finalized record. You can\'t modify this');
            exit();
        }

        $editForm = $this->createEditForm($purchase);
        $purchaseLine = new PurchaseLine();
        $lineForm = $this->createForm(new PurchaseLineType($this->get('security.context')), $purchaseLine, array(
                'action' => 'javascript:void(0);',
                'method' => 'POST',
            ));
        $editForm->handleRequest($request);

        $data = $this->get('request')->request->all();
        $data = $data['purchase_line'];
        $batch = new BatchBusinessModel($em);

        if ($editForm->isValid()) {
            foreach($data['product'] as $key => $product)
            {
                $line = new PurchaseLine();
                $line->setPurchase($purchase);
                $line->setBatch($batch->createBatch());
                $line->setProduct($em->getRepository('RaProductBundle:Product')->findOneById($product));
                $line->setAmount($data['amount'][$key]);
                $line->setPrice($data['price'][$key]);
                $em->persist($line);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('purchase_edit', array('id' => $id)));
        }

        $purchaseLines = $em->getRepository('AcmePurchaseBundle:PurchaseLine')->findBy(array('purchase' => $id));

        return $this->render('AcmePurchaseBundle:Purchase:edit.html.twig', array(
                'purchase'      => $purchase,
                'form'   => $editForm->createView(),
                'line_form' => $lineForm->createView(),
                'lines' => $purchaseLines
            ));
    }
    /**
     * Deletes a Purchase entity.
     *
     */
    public function deleteAction($id)
    {
        try
        {
            $em = $this->getDoctrine()->getManager();
            $purchase = $em->getRepository('AcmePurchaseBundle:Purchase')->find($id);

            if (!$purchase) {
                throw $this->createNotFoundException('Unable to find Purchase entity.');
            }
            if($this->container->getParameter('statusFinalized') === $purchase->getStatus())
            {
                throw new AccessDeniedException('This is a finalized record. You can\'t modify this');
                exit();
            }

            $lines = $em->getRepository('AcmePurchaseBundle:Purchase')->findBy(array('purchase' => $purchase->getId()));
            if(!empty($lines))
                foreach($lines as $line)
                    $em->remove($line);

            $em->remove($purchase);
            $em->flush();
        }
        catch(\Exception $e)
        {
            $this->get('session')->getFlashBag()->set('error', 'Error: You can\'t delete this record. You are getting this message because somewhere you already used this record as reference or this record not exist. If you want to know more please contact system administrator.');
            return $this->redirect($this->get('request')->server->get('HTTP_REFERER'));
        }

        return $this->redirect($this->get('request')->server->get('HTTP_REFERER'));
    }

    /**
     * Creates a form to delete a Purchase entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('purchase_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }

    /*
     * Delete Line
     * */
    public function ajaxDeleteLineAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $line = $em->getRepository('AcmePurchaseBundle:PurchaseLine')->find($id);

        if(!$line)
        {
            return new HTTPResponse('Invalid purchase line', 404);
            exit();
        }

        if($this->container->getParameter('statusFinalized') === $line->getPurchase()->getStatus())
        {
            return new HTTPResponse('This is a finalized record. You don\'t have access to modify this', 403);
            exit();
        }
        $batch = $line->getBatch();
        $em->remove($line);
        $em->remove($batch);
        $em->flush();

        return new HTTPResponse("Successfully deleted.", 200);
    }

    /*
     * Finalize Purchase
     * */
    public function finalizeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $purchase = $em->getRepository('AcmePurchaseBundle:Purchase')->find($id);

        if (!$purchase) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }
        if($this->container->getParameter('statusFinalized') === $purchase->getStatus())
        {
            throw new AccessDeniedException('This is a finalized record. You can\'t modify this');
            exit();
        }

        $purchaseStatus = new PurchaseStatus($em, $this->container->get('security.context'));
        $purchaseStatus->finalizePurchase($purchase);
        return $this->redirect($this->generateUrl('purchase_show', array('id' => $id)));
    }

    public function deFinalizeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $purchase = $em->getRepository('AcmePurchaseBundle:Purchase')->find($id);

        if (!$purchase) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }
        if($this->container->getParameter('statusFinalized') !== $purchase->getStatus())
        {
            throw new AccessDeniedException('This is not a finalized record.');
            exit();
        }

        $purchaseStatus = new PurchaseStatus($em, $this->container->get('security.context'));
        $res = $purchaseStatus->deFinalizePurchase($purchase);
        if(!$res)
            $this->get('session')->getFlashBag()->set('error', 'You can\'t definalize this record because stocks already used.');
        return $this->redirect($this->generateUrl('purchase_show', array('id' => $id)));
    }
}