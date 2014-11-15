<?php

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AvailableProductController extends Controller
{
	public function availableProductAction()
	{
		$result = $this->_getAvailableProductResult();
		var_dump($result);
		return $this->render('AcmeWidgetBundle:AvailableProduct:availableProduct.html.twig');
	}

	public function _getAvailableProductResult()
	{
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
    		'SELECT (sum(p.quantity)-(i.quantity) as avaiableStock
    		FROM AcmePurchaseBundle:PurchaseLine p
    		join(p.IssueLine)
    		'
		);

		$products = $query->getResult();


		


	/*
		$em = $this->getDoctrine()->getManager();

		$query = $em->createQuery(
			'SELECT sum(pl.quantity) as available
            FROM AcmePurchaseBundle:PurchaseLine pl')

		$products = $query->getResult();

        $query = $em->createQuery(
        	'SELECT sum(i.quantity) as unavailable
            FROM AcmeIssueBundle:IssueLine i')

        $products['unavailable'] = $query->getResult();

        return $result = $available['available'] - $unavailable['unavailable'];*/
	}
}