<?php
/**
 * Created by PhpStorm.
 * User: jony
 * Date: 7/19/14
 * Time: 10:39 AM
 */

namespace Acme\DashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LastController extends Controller{

    public function indexAction($max = 5)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p')
            ->from('AcmePurchaseBundle:Purchase', 'p')
            ->orderBy('p.purchaseDate', 'DESC')
            ->setMaxResults($max);

        $query = $qb->getQuery();
        $purchases = $query->getResult();

        return $this->render('AcmeDashBundle:Last:index.html.twig', array(
                'purchase' => $purchases,
            ));
    }
} 