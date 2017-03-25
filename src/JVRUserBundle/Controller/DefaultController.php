<?php

namespace JVRUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JVRUserBundle:Default:index.html.twig');
    }
}
