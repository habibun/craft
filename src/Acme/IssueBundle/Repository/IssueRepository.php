<?php

namespace Acme\IssueBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * IssueRepository
 */
class IssueRepository extends EntityRepository
{
    public function getProductCurrentStockResult($product = null)
    {
        $dql = 'SELECT sum(pl.quantity) as available
                FROM AcmePurchaseBundle:PurchaseLine pl
                WHERE pl.product = :product';

        $available = $this->_em->createQuery($dql)
                ->setParameter('product', $product)
                ->getSingleResult();


        $dql = 'SELECT sum(i.quantity) as unavailable
                FROM AcmeIssueBundle:IssueLine i
                WHERE i.product = :product';

        $unavailable = $this->_em->createQuery($dql)
                ->setParameter('product', $product)
                ->getSingleResult();                

        return $result = $available['available'] - $unavailable['unavailable'];
    }
}