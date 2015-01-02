<?php

namespace Acme\InvoiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class InvoiceController extends Controller
{
	public function indexAction()
	{
		return $this->render('AcmeInvoiceBundle:Invoice:index.html.twig');
	}

	public function newAction()
	{
		return $this->render('AcmeInvoiceBundle:Invoice:new.html.twig');
	}
}