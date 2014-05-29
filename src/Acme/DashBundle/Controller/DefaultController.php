<?php

namespace Acme\DashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeDashBundle:Default:index.html.twig', array('name' => $name));
    }
}
