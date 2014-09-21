<?php

namespace Acme\IssueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\IssueBundle\Entity\Issue;
use Acme\IssueBundle\Form\IssueType;
use Acme\IssueBundle\Entity\IssueLine;
use Acme\IssueBundle\Form\IssueLineType;
use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Symfony\Component\HttpFoundation\Request;


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

    public function getIssueResultAction()
    {
        $datatable = $this->get('lankit_datatables')->getDatatable('AcmeIssueBundle:Issue');

        return $datatable->getSearchResults();
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
        $lineForm = $this->createForm(
            new IssueLineType(),
            new IssueLine(),
            array(
                'method' => 'post',
                'action' => '#'
            )
        );
        $form->handleRequest($request);
        $data = $this->get('request')->request->all();
        $data = $data['issue_line'];

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setStatus('false');
            $entity->setCreatedBy($this->getUser());
            $em->persist($entity);
            foreach ($data['product'] as $key => $product) {
                $line = new IssueLine();
                $line->setIssue($entity);
                $line->setProduct($em->getRepository('AcmeSetupBundle:Product')->find($product));
                $line->setQuantity($data['quantity'][$key]);
                $line->setIssueTo($data['issueTo'][$key]);
                $line->setReferenceNumber($data['referenceNumber'][$key]);
                $em->persist($line);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('issue_show', array('id' => $entity->getId())));
        }

        return $this->render(
            'AcmeIssueBundle:Issue:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
                'line_form' => $lineForm->createView()
            )
        );
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
        $form = $this->createForm(
            new IssueType(),
            $entity,
            array(
                'action' => $this->generateUrl('issue_create'),
                'method' => 'POST',
            )
        );

        return $form;
    }

    /**
     * Displays a form to create a new Issue entity.
     *
     */
    public function newAction()
    {
        $entity = new Issue();
        $form = $this->createCreateForm($entity);
        $lineForm = $this->createForm(
            new IssueLineType(),
            new IssueLine(),
            array(
                'method' => 'post',
                'action' => '#'
            )
        );

        return $this->render(
            'AcmeIssueBundle:Issue:new.html.twig',
            array(
                'entity' => $entity,
                'form' => $form->createView(),
                'line_form' => $lineForm->createView()
            )
        );
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

        return $this->render(
            'AcmeIssueBundle:Issue:show.html.twig',
            array(
                'issue' => $entity,
                'lines' => $lines,
            )
        );
    }

    /**
     * Displays a form to edit an existing Issue entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $issue = $em->getRepository('AcmeIssueBundle:Issue')->find($id);

        if (!$issue) {
            throw $this->createNotFoundException('Unable to find Issue entity.');
        }
        if ($issue->getStatus() == 1) {
            throw $this->createNotFoundException('Issue is already finalized');
        }
        $editForm = $this->createEditForm($issue);
        $issueLine = new IssueLine();
        $lineForm = $this->createForm(
            new IssueLineType($this->get('security.context')),
            $issueLine,
            array(
                'action' => 'javascript:void(0);',
                'method' => 'POST',
            )
        );

        $issueLines = $em->getRepository('AcmeIssueBundle:IssueLine')->findBy(array('issue' => $id));

        return $this->render(
            'AcmeIssueBundle:Issue:edit.html.twig',
            array(
                'issue' => $issue,
                'form' => $editForm->createView(),
                'line_form' => $lineForm->createView(),
                'lines' => $issueLines
            )
        );
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
        $form = $this->createForm(
            new IssueType(),
            $entity,
            array(
                'action' => $this->generateUrl('issue_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            )
        );

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

        $editForm = $this->createEditForm($entity);
        $lineForm = $this->createForm(
            new IssueLineType(),
            new IssueLine(),
            array(
                'method' => 'post',
                'action' => '#'
            )
        );
        $lines = $em->getRepository('AcmeIssueBundle:IssueLine')->findBy(
            array('issue' => $id)
        );

        $editForm->handleRequest($request);
        $data = $this->get('request')->request->all();
        $data = isset($data['issue_line']) ? $data['issue_line'] : array();

        if ($editForm->isValid()) {
            $entity->setUpdatedBy($this->getUser());
            if (!empty($data)) {
                foreach ($data['product'] as $key => $product) {
                    $line = new IssueLine();
                    $line->setIssue($entity);
                    $line->setProduct($em->getRepository('AcmeSetupBundle:Product')->find($product));
                    $line->setQuantity($data['quantity'][$key]);
                    $line->setIssueTo($data['issueTo'][$key]);
                    $line->setReferenceNumber($data['referenceNumber'][$key]);
                    $em->persist($line);
                }
            }

            $em->flush();
            $this->get('session')->getFlashBag()->add('heads_up', "Your change was successfully Saved");

            return $this->redirect($this->generateUrl('issue_edit', array('id' => $id)));
        }

        return $this->render(
            'AcmeIssueBundle:Issue:edit.html.twig',
            array(
                'entity' => $entity,
                'edit_form' => $editForm->createView(),
                'line_form' => $lineForm->createView(),
                'lines' => $lines
            )
        );
    }

    /**
     * Deletes a Issue entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AcmeIssueBundle:Issue')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Issue entity.');
        }
        if ($entity->getStatus() == 1)
            throw $this->createNotFoundException('Issue is already finalized');

        $lines = $em->getRepository('AcmeIssueBundle:IssueLine')->findBy(array('issue' => $entity));
        if (!empty($lines))
            foreach ($lines as $line)
                $em->remove($line);

        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('oh_snap', "Successfully Deleted");

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
            ->getForm();
    }

    public function ajaxDeleteLineAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $line = $em->getRepository('AcmeIssueBundle:IssueLine')->find($id);

        if (!$line) {
            return new HTTPResponse('Invalid issue line', 404);
            exit();
        }
        $em->remove($line);
        $em->flush();

        return new HTTPResponse("Successfully deleted.", 200);
    }

    public function finalizeAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeIssueBundle:Issue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Issue entity.');
        }
        $entity->setStatus(1);
        $entity->setFinalizedBy($this->getUser());
        $entity->setFinalizedAt(new \DateTime('now'));
        $em->flush();
        $this->get('session')->getFlashBag()->add('well_done', "Finalized Successfully!");

        return $this->redirect($this->generateUrl('issue_show', array('id' => $id)));
    }

    public function deFinalizeAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeIssueBundle:Issue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Issue entity.');
        }
        $entity->setStatus(0);
        $entity->setFinalizedAt(null);
        $em->flush();
        $this->get('session')->getFlashBag()->add('oh_snap', "De-Finalized Successfully!");

        return $this->redirect($this->generateUrl('issue_show', array('id' => $id)));
    }

}
