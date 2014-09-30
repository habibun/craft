<?php

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeWidgetBundle:Default:index.html.twig', array('name' => $name));
    }
}
