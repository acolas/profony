<?php

namespace Profony\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('ProfonySiteBundle:Default:index.html.twig', array('name' => $name));
    }
}
