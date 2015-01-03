<?php

namespace Acme\InvoiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeInvoiceBundle:Default:index.html.twig', array('name' => $name));
    }
}
