<?php

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StateOverviewController extends Controller
{
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
}