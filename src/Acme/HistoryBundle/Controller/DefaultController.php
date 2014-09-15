<?php

namespace Acme\HistoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeHistoryBundle:Default:index.html.twig', array('name' => $name));
    }
}
