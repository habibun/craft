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
                        'SELECT sum(p.createdBy) as name FROM
                        AcmePurchaseBundle:Purchase p
                        join p.createdBy u
                        WHERE u.username = :username')
                    ->setParameters(
                            array('username' => $username->getUsername())
                        );
                    
        $workProgress= $query->getOneOrNullResult();


        return $this->render(
            'AcmeWidgetBundle:WorkProgress:workProgress.html.twig',
            array(
                'workProgress' => $workProgress
                
            )
        );
    }

    private function _getWorkProgressResults()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT u.username as name, 
             p.id id,
             count(p.createdBy) AS total_created,
             count(p.updatedBy) as total_updated,
             count(p.finalizedBy) as total_finalized
             FROM AcmePurchaseBundle:Purchase p
             JOIN p.createdBy u
             group by name'
        );
        $result = $query->getResult();

        return $result;
    }
} 



