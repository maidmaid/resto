<?php

namespace Mnu\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MnuMainBundle:Default:index.html.twig', array('name' => $name));
    }
}
