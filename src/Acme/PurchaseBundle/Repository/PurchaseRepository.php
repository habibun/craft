<?php

namespace Acme\PurchaseBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

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
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function getSupplierDetailResult($supplier = null)
    {
        $dql = 'SELECT SUM (pl.price) as price, (pr.name) as product, (s.name) as supplier
        from AcmePurchaseBundle:Purchase p
        join p.lines pl
        join pl.product pr
        join p.supplier s
        where s.id = :supplier and p.status = 1
        GROUP BY pl.product';

        $query = $this->_em->createQuery($dql)
            ->setParameter('supplier', $supplier);

        return $query->getResult();
    }
}