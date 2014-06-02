<?php

namespace Acme\DashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('dashboard'));
    }

    public function dashboardAction()
    {
        return $this->render('AcmeDashBundle:Dashboard:index.html.twig');
    }
}
