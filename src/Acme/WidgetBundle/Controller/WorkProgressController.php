<?php
/**
 * Created by PhpStorm.
 * User: jony
 * Date: 10/5/14
 * Time: 9:55 PM
 */

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkProgressController extends Controller
{

    public function workProgressAction($username = null)
    {
        $username = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT count(p.createdBy) as total_created, count(p.updatedBy) as total_updated, count(p.finalizedBy) as total_finalized
                         FROM AcmePurchaseBundle:Purchase p
                         join p.createdBy u
                         WHERE u.username = :username'
        )
            ->setParameters(
                array('username' => $username->getUsername())
            );

        $workProgress = $query->getOneOrNullResult();

        return $this->render(
            'AcmeWidgetBundle:WorkProgress:workProgress.html.twig',
            array(
                'workProgress' => $workProgress

            )
        );
    }

    public function workProgressAllAction()
    {
        $result = $this->_getWorkProgressAllResult();

        // var_dump($result);
        return $this->render(
            'AcmeWidgetBundle:WorkProgress:workProgressAll.html.twig',
            array(
                'result' => $result)
        );
    }

    private function _getWorkProgressAllResult()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
            FROM AcmePurchaseBundle:PurchaseLine p

            '
        );

        $products = $query->getResult();

        /*
            $em = $this->getDoctrine()->getManager();

            $query = $em->createQuery(
                'SELECT sum(pl.quantity) as available
                FROM AcmePurchaseBundle:PurchaseLine pl')

            $products = $query->getResult();

            $query = $em->createQuery(
                'SELECT sum(i.quantity) as unavailable
                FROM AcmeIssueBundle:IssueLine i')

            $products['unavailable'] = $query->getResult();

            return $result = $available['available'] - $unavailable['unavailable'];*/
    }
}