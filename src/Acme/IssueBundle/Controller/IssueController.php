<?php

namespace Acme\IssueBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\IssueBundle\Entity\Issue;
use Acme\IssueBundle\Form\IssueType;
use Acme\IssueBundle\Entity\IssueLine;
use Acme\IssueBundle\Form\IssueLineType;
use LanKit\DatatablesBundle\Datatables\Datatable;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;


/**
 * Issue controller.
 *
 */
class IssueController extends Controller
{

    /**
     * Lists all Issue entities.
     *
     */
    public function indexAction()
    {
        return $this->render('AcmeIssueBundle:Issue:index.html.twig');
    }

    public function getIssueLineResultAction()
    {
        $datatable = $this->get('lankit_datatables')->getDatatable('AcmeIssueBundle:IssueLine');

        return $datatable->getSearchResults();
    }

    /**
     * Creates a new Issue entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Issue();
        $form = $this->createCreateForm($entity);
        $lineForm = $this->createForm(new IssueLineType(), new IssueLine(), array(
            'method' => 'post',
            'action'=> '#'
        ));
        $form->handleRequest($request);
        $data = $this->get('request')->request->all();
        $data = $data['issue_line'];

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setStatus('false');
            $em->persist($entity);
            foreach($data['product'] as $key => $product)
            {
                $line = new IssueLine();
                $line->setIssue($entity);
                $line->setProduct($em->getRepository('AcmeSetupBundle:Product')->find($product));
                $line->setQuantity($data['quantity'][$key]);
                $line->setComment($data['comment'][$key]);
                $em->persist($line);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('issue_show', array('id' => $entity->getId())));
        }

        return $this->render('AcmeIssueBundle:Issue:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'line_form' => $lineForm->createView()
        ));
    }

    /**
    * Creates a form to create a Issue entity.
    *
    * @param Issue $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Issue $entity)
    {
        $form = $this->createForm(new IssueType(), $entity, array(
            'action' => $this->generateUrl('issue_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Issue entity.
     *
     */
    public function newAction()
    {
        $entity = new Issue();
        $form   = $this->createCreateForm($entity);
        $lineForm = $this->createForm(new IssueLineType(), new IssueLine(), array(
            'method' => 'post',
            'action'=> '#'
        ));

        return $this->render('AcmeIssueBundle:Issue:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'line_form' =>$lineForm->createView()
        ));
    }

    /**
     * Finds and displays a Issue entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeIssueBundle:Issue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Issue entity.');
        }
        $lines = $em->getRepository('AcmeIssueBundle:IssueLine')->findBy(
            array('issue' => $id)
        );

        return $this->render('AcmeIssueBundle:Issue:show.html.twig', array(
            'issue'      => $entity,
            'lines' => $lines,        ));
    }

    /**
     * Displays a form to edit an existing Issue entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeIssueBundle:Issue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Issue entity.');
        }

        $editForm = $this->createEditForm($entity);
        $lineForm = $this->createForm(new IssueLineType(), new IssueLine(), array(
                'method' => 'post',
                'action'=> '#'
            ));

        $lines = $em->getRepository('AcmeIssueBundle:IssueLine')->findBy(
            array('issue' => $id)
        );

        return $this->render('AcmeIssueBundle:Issue:edit.html.twig', array(
                'entity'      => $entity,
                'form'   => $editForm->createView(),
                'line_form' => $lineForm->createView(),
                'lines' => $lines
            ));
    }

    /**
    * Creates a form to edit a Issue entity.
    *
    * @param Issue $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Issue $entity)
    {
        $form = $this->createForm(new IssueType(), $entity, array(
            'action' => $this->generateUrl('issue_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        return $form;
    }
    /**
     * Edits an existing Issue entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeIssueBundle:Issue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Issue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('issue_edit', array('id' => $id)));
        }

        return $this->render('AcmeIssueBundle:Issue:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Issue entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeIssueBundle:Issue')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Issue entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issue'));
    }

    /**
     * Creates a form to delete a Issue entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issue_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function ajaxDeleteLineAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $line = $em->getRepository('AcmeIssueBundle:IssueLine')->find($id);

        if(!$line)
        {
            return new HTTPResponse('Invalid issue line', 404);
            exit();
        }

        if(2 === $line->getIssue()->getStatus())
        {
            return new HTTPResponse('This is a finalized record. You don\'t have access to modify this', 403);
            exit();
        }
        $em->remove($line);
        $em->flush();

        return new HTTPResponse("Successfully deleted.", 200);
    }
}
