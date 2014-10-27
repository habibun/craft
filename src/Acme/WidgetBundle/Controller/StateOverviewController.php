<?php

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StateOverviewController extends Controller
{
    public function stateOverviewAction()
    {
        return $this->render('AcmeWidgetBundle:StateOverview:stateOverview.html.twig');
    }

    public function totalCostAction()
    {
        $totalCost = $this->_getTotalCostResults();

        return $this->render(
            'AcmeWidgetBundle:StateOverview:totalCost.html.twig',
            array(
                'totalCost' => $totalCost,
            )
        );
    }

    private function _getTotalCostResults()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT sum(pl.price) as total_price, pu.status
             FROM AcmePurchaseBundle:PurchaseLine pl
             JOIN pl.purchase pu
             where pu.status = 1'
        );
        $result = $query->getResult();
        return $result;
    }

    public function totalUserAction()
    {
        $query_builder = $this->getDoctrine()->getManager()->createQueryBuilder();
        $totalUser = $query_builder->select('COUNT(u) total_user')
            ->from('AcmeUserBundle:User', 'u')
            ->getQuery()
            ->getResult();

        return $this->render(
            'AcmeWidgetBundle:StateOverview:totalUser.html.twig',
            array(
                'totalUser' => $totalUser,
            )
        );
    }

    public function draftedIssueAction()
    {
        $query_builder = $this->getDoctrine()->getManager()->createQueryBuilder();
        $draftedIssue = $query_builder->select('count(i.status) total_drafted_issue')
            ->from('AcmeIssueBundle:Issue','i')
            ->where('i.status = 0')
            ->getQuery()
            ->getResult();
        
        return $this->render('AcmeWidgetBundle:StateOverview:draftedIssue.html.twig',array(
            'draftedIssue' => $draftedIssue,
            )
        );
    }

    public function draftedPurchaseAction()
    {
        $query_builder = $this->getDoctrine()->getManager()->createQueryBuilder();
        $draftedPurchase = $query_builder->select('count(p.status) total_drafted_purchase')
            ->from('AcmePurchaseBundle:Purchase','p')
            ->where('p.status = 0')
            ->getQuery()
            ->getResult();
        
        return $this->render('AcmeWidgetBundle:StateOverview:draftedPurchase.html.twig',array(
            'draftedPurchase' => $draftedPurchase,
            )
        );
    }
}
