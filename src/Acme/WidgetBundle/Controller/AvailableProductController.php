<?php

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AvailableProductController extends Controller
{
	public function availableProductAction()
	{
		return $this->render('AcmeWidgetBundle:AvailableProduct:availableProduct.html.twig');
	}
}