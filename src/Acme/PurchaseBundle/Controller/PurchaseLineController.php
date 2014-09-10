<?php
/**
 * Created by PhpStorm.
 * User: Habibun
 * Date: 9/10/14
 * Time: 2:48 PM
 */

namespace Acme\PurchaseBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PurchaseLineController extends Controller{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmePurchaseBundle:PurchaseLine')->findAll();

        return $this->render('AcmePurchaseBundle:PurchaseLine:index.html.twig',array(
                'entities' => $entities
            ));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmePurchaseBundle:PurchaseLine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PurchaseLine entity.');
        }

        return $this->render(
            'AcmePurchaseBundle:PurchaseLine:show.html.twig',
            array(
                'entity' => $entity,
            )
        );
    }

} 