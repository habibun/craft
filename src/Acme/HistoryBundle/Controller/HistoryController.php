<?php
/**
 * Created by PhpStorm.
 * User: Habibun
 * Date: 9/15/14
 * Time: 10:12 AM
 */

namespace Acme\HistoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HistoryController extends Controller{

    public function purchaseAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmePurchaseBundle:PurchaseLine')->findAll();

        return $this->render('AcmeHistoryBundle:History:purchaseHistory.html.twig',array(
                'entities' => $entities
            ));
    }

    public function issueAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmeIssueBundle:IssueLine')->findAll();

        return $this->render('AcmeHistoryBundle:History:issueHistory.html.twig',array(
                'entities' => $entities
            ));
    }

}