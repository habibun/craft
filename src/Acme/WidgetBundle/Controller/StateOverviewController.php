<?php

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\WidgetBundle\Repository\StateOverviewModel;

class StateOverviewController extends Controller
{
    public function stateOverviewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $state = new StateOverviewModel($em);

        $totalCost = $state->_getTotalCostResults();
        $totalUser = $state->_getTotalUserResults();
        $draftedIssue = $state->_getdraftedIssueResults();
        $draftedPurchase = $state->_getDraftedPurchaseResults();
             
        return $this->render('AcmeWidgetBundle:StateOverview:stateOverview.html.twig',
            array(
                'totalCost' => $totalCost,
                'totalUser' => $totalUser,
                'draftedIssue' => $draftedIssue,
                'draftedPurchase' => $draftedPurchase,
            ));
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
            ->from('AcmeIssueBundle:Issue', 'i')
            ->where('i.status = 0')
            ->getQuery()
            ->getResult();

        return $this->render(
            'AcmeWidgetBundle:StateOverview:draftedIssue.html.twig',
            array(
                'draftedIssue' => $draftedIssue,
            )
        );
    }

    public function draftedPurchaseAction()
    {
        $query_builder = $this->getDoctrine()->getManager()->createQueryBuilder();
        $draftedPurchase = $query_builder->select('count(p.status) total_drafted_purchase')
            ->from('AcmePurchaseBundle:Purchase', 'p')
            ->where('p.status = 0')
            ->getQuery()
            ->getResult();

        return $this->render(
            'AcmeWidgetBundle:StateOverview:draftedPurchase.html.twig',
            array(
                'draftedPurchase' => $draftedPurchase,
            )
        );
    }
}
