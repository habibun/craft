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
        $draftedIssue = $state->_getDraftedIssueResults();
        $draftedPurchase = $state->_getDraftedPurchaseResults();

        return $this->render('AcmeWidgetBundle:StateOverview:stateOverview.html.twig',
            array(
                'totalCost' => $totalCost,
                'totalUser' => $totalUser,
                'draftedIssue' => $draftedIssue,
                'draftedPurchase' => $draftedPurchase,
            ));
    }

}
