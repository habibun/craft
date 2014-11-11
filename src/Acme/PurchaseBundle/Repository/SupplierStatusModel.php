<?php

namespace Acme\Purchase\Repository;

use Doctrine\ORM\EntityManager;

class SupplierStatusModel
{
    /*
    * @var Doctrine\Orm\EntityManager
    * */

	private $em;

	public function __construct(EntityManager $em)
    {
        $this->em = $em;
    } 

    public function _getSupplierPurchaseStatus(EntityManager $em,Supplier $supplier)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT sum(pl.price) as status
             FROM AcmePurchaseBundle:Purchase p
             join p.lines pl
             join p.supplier s
             where s.supplier = :supplier')

            ->setParameters(
                array('supplier' => $supplier)
            );

        return $query->getSingleResult();
    }
    
}