<?php
/**
 * Created by PhpStorm.
 * User: jony
 * Date: 17/12/2014
 * Time: 10:15 AM
 */

namespace Acme\EmailBundle\Repository;


use Doctrine\ORM\EntityRepository;

class EmailRepository extends EntityRepository
{

    public function searchEmailResult($email)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT e FROM AcmeEmailBundle:Email e where e.email like :email')
            ->setParameter('email', '%' . $email . '%')
            ->execute();
    }
}