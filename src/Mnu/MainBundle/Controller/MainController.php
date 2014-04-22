<?php

namespace Mnu\MainBundle\Controller;

use Mnu\MainBundle\Form\RestaurantType;
use Mnu\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('MnuMainBundle:Default:index.html.twig');
    }
    
    public function adminAction(Request $request)
    {
	/* @var $user User */
	$user = $this->getUser();
	$restaurant = $user->getRestaurant();
	
	$form = $this->createForm(new RestaurantType(), $restaurant);
	$form->handleRequest($request);
	
	if($form->isValid())
	{
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($restaurant);
	    $em->flush();
	}
	
        return $this->render('MnuMainBundle:Admin:index.html.twig', array(
	    'form' => $form->createView()
	));
    }
}
