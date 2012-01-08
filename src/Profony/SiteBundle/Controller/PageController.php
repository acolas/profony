<?php
namespace Profony\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProfonySiteBundle:Page:index.html.twig');
    }
}