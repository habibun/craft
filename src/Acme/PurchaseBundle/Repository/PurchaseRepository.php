<?php

namespace Acme\PurchaseBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Acme\PurchaseBundle\Entity\Purchase;

/**
 * PurchaseRepository
 */
class PurchaseRepository extends EntityRepository
{

    public function _finalize($id)
    {
        $purchase = new Purchase();
        $purchase->setStatus(1);
        $purchase->setFinalizedBy('jony');
        $purchase->setFinalizedAt(new \DateTime('now'));
        $this->_em->persist($purchase);
        $this->_em->flush();

        return true;
    }

}