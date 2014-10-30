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
                        'SELECT sum(p.createdBy) as total_created, sum(p.updatedBy) as total_updated, sum(p.finalizedBy) as total_finalized
                         FROM AcmePurchaseBundle:Purchase p
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
} 



