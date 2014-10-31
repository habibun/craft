<?php
/**
 * Created by PhpStorm.
 * User: Habibun
 * Date: 10/31/14
 * Time: 3:18 AM
 */

namespace Acme\WidgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LockScreenController extends Controller
{
    public function lockScreenAction()
    {
        return $this->render('AcmeWidgetBundle:LockScreen:lockScreen.html.twig');
    }
}