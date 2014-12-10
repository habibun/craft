<?php

namespace Acme\WidgetBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;

class StateOverviewModel
{
	private $em;

	public function __construct(EntityManager $em)
    {
        $this->em = $em;
    } 

    //get total cost
	public function _getTotalCostResults()
    {
    	$query_builder = $this->em->createQueryBuilder();
    	$query = $query_builder
    			->select('sum(pl.price) total_price')
    			->from('AcmePurchaseBundle:PurchaseLine', 'pl')
    			->join('pl.purchase', 'pu')
    			->andWhere('pu.status = 1')
    			->getQuery();

	    try {
	        return $query->getSingleResult();
	    } catch (NoResultException $e) {
	        return null;
	    }
    }

    //get total user
    public function _getTotalUserResults()
    {
    	$query_builder = $this->em->createQueryBuilder();
    	$query = $query_builder
    			->select('COUNT(u) total_user')
            	->from('AcmeUserBundle:User', 'u')
            	->getQuery();
            	
	    try {
	        return $query->getSingleResult();
	    } catch (NoResultException $e) {
	        return null;
	    }
    }

    //get drafted issue 
    public function _getdraftedIssueResults()
    {
    	$query_builder = $this->em->createQueryBuilder();
    	$query = $query_builder
	    		->select('count(i.status) total_drafted_issue')
	            ->from('AcmeIssueBundle:Issue', 'i')
	            ->where('i.status = 0')
	            ->getQuery();

	    try {
        return $query->getSingleResult();
	    } catch (NoResultException $e) {
	        return null;
	    }
    }

    //get drafted purchase
    public function _getDraftedPurchaseResults()
    {
    	$query_builder = $this->em->createQueryBuilder();
    	$query = $query_builder
	    		->select('count(p.status) total_drafted_purchase')
	            ->from('AcmePurchaseBundle:Purchase', 'p')
	            ->where('p.status = 0')
	            ->getQuery();

	    try {
        return $query->getSingleResult();
	    } catch (NoResultException $e) {
	        return null;
	    }
    }
    
}