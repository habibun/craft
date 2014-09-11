<?php
/**
 * Created by PhpStorm.
 * User: Habibun
 * Date: 9/11/14
 * Time: 9:24 AM
 */

namespace Acme\IssueBundle\Controller;


use Acme\PurchaseBundle\Entity\PurchaseLine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IssueLineController extends Controller{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmeIssueBundle:IssueLine')->findAll();

        return $this->render('AcmeIssueBundle:IssueLine:index.html.twig',array(
                'entities' => $entities
            ));
    }

    public function showAction($id)
    {
        $p = new PurchaseLine();
        $id = $p->getId();


        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeIssueBundle:IssueLine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IssueLine entity.');
        }

        return $this->render(
            'AcmeIssueBundle:IssueLine:show.html.twig',
            array(
                'entity' => $entity,
            )
        );
    }

} 