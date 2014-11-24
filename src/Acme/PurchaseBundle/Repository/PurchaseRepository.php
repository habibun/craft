<?php

namespace Acme\PurchaseBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PurchaseRepository
 */
class PurchaseRepository extends EntityRepository
{
    public function getSupplierTotalPurchaseResult($supplier = null)
    {
        $dql = 'SELECT sum(pl.price) as total
             	FROM AcmePurchaseBundle:Purchase p
             	join p.lines pl
             	join p.supplier s
             	where (s.id = :supplier and p.status = 1)';

        $query = $this->_em->createQuery($dql)
            ->setParameter('supplier', $supplier);

        //when multiple parameter
        /*->setParameters(
            array('supplier' => $supplier)
        );*/

        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function getSupplierDetailResult($supplier = null)
    {
        $dql = 'select COUNT (pl.product) as timeof, SUM (pl.price) as price, (pl.product) as product_id
        from AcmePurchaseBundle:Purchase p
        join p.lines pl
        join p.supplier s
        where s.id = :supplier and p.status = 1';

        $query = $this->_em->createQuery($dql)
            ->setParameter('supplier',$supplier);

        return $query->getSingleResult();
    }
}