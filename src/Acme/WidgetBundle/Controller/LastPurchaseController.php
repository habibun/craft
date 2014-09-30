<?php
/**
 * Created by PhpStorm.
 * User: Habibun
 * Date: 9/30/14
 * Time: 9:19 AM
 */

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LastPurchaseController extends Controller
{

    public function lastPurchaseAction($max = 5)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p')
            ->from('AcmePurchaseBundle:Purchase', 'p')
            ->orderBy('p.purchaseDate', 'DESC')
            ->setMaxResults($max);

        $query = $qb->getQuery();
        $lastPurchase = $query->getResult();

        return $this->render(
            'AcmeWidgetBundle:LastPurchase:index.html.twig',array(
                'lastPurchase' => $lastPurchase,
            )
        );
    }
}