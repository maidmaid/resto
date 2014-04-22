<?php

namespace Mnu\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('MnuMainBundle:Default:index.html.twig');
    }
    
    public function adminAction()
    {
        return $this->render('MnuMainBundle:Admin:index.html.twig');
    }
}
