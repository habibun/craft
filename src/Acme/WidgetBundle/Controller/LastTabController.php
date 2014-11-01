<?php
/**
 * Created by PhpStorm.
 * User: Jony
 * Date: 9/30/14
 * Time: 9:19 AM
 */

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LastTabController extends Controller
{
    public function lastTabAction($max = 5)
    {
        $result = array();
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        //search for last purchase
        $qb->select('p')
            ->from('AcmePurchaseBundle:PurchaseLine', 'p')
            ->orderBy('pu.purchaseDate', 'DESC')
            ->join('p.purchase', 'pu')
            ->join('p.product','pr')
            ->addSelect("pu")
            ->addSelect("pr") 
            ->andWhere('pu.status = 1');

        if(false === is_null($max))
            $qb->setMaxResults($max);

        $query = $qb->getQuery();
        $result['lastPurchase'] = $query->getResult();

        //search for last issue
        $qb->select('i')
            ->from('AcmeIssueBundle:IssueLine', 'i')
            ->orderBy('iss.issueDate', 'DESC')
            ->join('i.issue', 'iss')
            ->addSelect("iss")
            ->andWhere('iss.status = 1');

        if(false === is_null($max))
            $qb->setMaxResults($max);

        $query = $qb->getQuery();
        $result['lastIssue'] = $query->getResult();

        //search for last login
        $query = $em->createQuery('SELECT u FROM AcmeUserBundle:User u 
                WHERE NOT u.enabled LIKE :enabled
                ORDER BY u.lastLogin DESC')
            ->setParameter('enabled', '%"1"%' );

        if ($max){
            $query->setMaxResults($max);
        };
            
        $users = $query->getResult();      

        return $this->render(
            'AcmeWidgetBundle:LastTab:lastTab.html.twig',array(
                'result' => $result,
                'users' => $users
            )
        );
    }
}