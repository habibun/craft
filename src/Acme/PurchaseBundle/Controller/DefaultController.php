<?php

namespace Acme\PurchaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmePurchaseBundle:Default:index.html.twig', array('name' => $name));
    }
}
