<?php
namespace Acme\InvoiceBundle\Repository;

use Doctrine\ORM\EntityRepository;

class InvoiceRepository extends EntityRepository
{
    public function getActiveJobs($limit = null, $offset = null, $kind = 'createdAt', $order = 'DESC') {
    	$qb = $this->createQueryBuilder('j')
        ->orderBy('j.' . $kind, $order);

    	if ($limit) {
    		$qb->setMaxResults($limit);
    	}
    	if ($offset) {
    		$qb->setFirstResult($offset);
    	}

    	$query = $qb->getQuery();
    	return $query->getResult();
    }
}
