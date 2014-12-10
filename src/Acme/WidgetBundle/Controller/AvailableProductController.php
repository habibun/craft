<?php

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AvailableProductController extends Controller
{
    public function availableProductAction()
    {
        $repository = $this->getDoctrine()
    		->getRepository('AcmePurchaseBundle:PurchaseLine');

		$query = $repository->createQueryBuilder('pl')
				->join('pl.purchase', 'pu')
				->join('pl.product', 'pr')
				->where('pu.status = 1')
				->having(
                "SUM(pl.quantity) > (
    			SELECT SUM(i.quantity)
    			FROM AcmeIssueBundle:IssueLine i
    			)"
            	)
				->groupBy('pr.name')
		    	->getQuery();

		$products = $query->getResult();
        die(\Doctrine\Common\Util\Debug::dump($products));

        /*return $this->render('AcmeWidgetBundle:AvailableProduct:index.html.twig',array(
                'ap' => $ap
            ));*/
    }

    private function _getAvailableProductResult()
    {

		$repository = $this->getDoctrine()
    		->getRepository('AcmePurchaseBundle:PurchaseLine');

		$query = $repository->createQueryBuilder('p')
		    ->getQuery();

		$products = $query->getResult();    	


        /*$em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        //search for last purchase
        $qb->select('pl.price')
            ->from('AcmePurchaseBundle:PurchaseLine', 'pl')
            ->join('pl.purchase', 'pu')
            ->join('pl.product', 'pr')
            ;

			$query = $qb->getQuery();
        	$result = $query->getResult();*/

    	/*$query->select('pl')
            ->from('AcmePurchaseBundle:PurchaseLine pl')
            ->join('pl.purchase', 'p')
            ->where('p.status = 1')
            ->having(
                "SUM(pl.quantity) - (
   	 			SELECT SUM(i.quantity)
    			FROM AcmeIssueBundle:IssueLine i
    			WHERE p.status = 1)"
            )
            ->groupBy('pl.product');
            $query = $qb->getQuery();

        $result = getResult;
        var_dump($result);*/
    }
}

/*
$query = $em->createQuery('
        SELECT p
        FROM WIC\ProductBundle\Entity\Product p
        LEFT JOIN WIC\ListingBundle\Entity\Listing l
            WITH l.product = p.id
        LEFT JOIN WIC\ListingBundle\Entity\ListingAma la
            WITH la.id = l.id
        WHERE la.standardProductIdValue LIKE :stringValue
        AND   p.account = :account_id')
        ->setMaxResults(10)
        ->setParameter('stringValue', "%B00AM204Q6%")
        ->setParameter('account_id', $account_id);*/

