<?php
/**
 * Created by PhpStorm.
 * User: jony
 * Date: 23/11/2014
 * Time: 1:38 PM
 */

namespace Acme\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    public function findUsernameResult($username)
    {
        //search within users for username
        $query = $this->_em->createQuery(
            'SELECT u
              FROM AcmeUserBundle:USER u
              WHERE u.username LIKE :username'
        );

        $query->setParameter('username', '%' . $username . '%');

        return $query->getResult();
    }
} 