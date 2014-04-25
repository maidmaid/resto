<?php

namespace Mnu\MainBundle\Controller;

use Mnu\MainBundle\Form\RestaurantType;
use Mnu\UserBundle\Entity\User;
use Mnu\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function indexAction()
    {
	/* @var $repository \Mnu\MainBundle\Entity\MenuRepository */
	$repository = $this->getDoctrine()->getManager()->getRepository('MnuMainBundle:Menu');
	/* @var $menus \Mnu\MainBundle\Entity\Menu[] */
	$menus = $repository->findBy(array(), null, 20);
	
        return $this->render('MnuMainBundle:Default:index.html.twig', array(
	    'menus' => $menus
	));
    }
    
    public function adminAction(Request $request)
    {
	/* @var $user User */
	$user = $this->getUser();	
	$userForm = $this->createForm(new UserType(), $user, array(
	    'action' => $this->generateUrl('mnu_main_admin_update_user')
	));
	
	$restaurant = $user->getRestaurant();
	$restaurantForm = $this->createForm(new RestaurantType(), $restaurant, array(
	    'action' => $this->generateUrl('mnu_main_admin_update_restaurant')
	));
	
        return $this->render('MnuMainBundle:Admin:index.html.twig', array(
	    'restaurantForm' => $restaurantForm->createView(),
	    'userForm' => $userForm->createView()
	));
    }
    
    public function updateUserAction(Request $request)
    {
	$user = $this->getUser();
	$form = $this->createForm(new UserType(), $user);
	$form->handleRequest($request);
	
	if($form->isValid())
	{
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($user);
	    $em->flush();
	}
	
	return $this->redirect($this->generateUrl('mnu_main_adminpage'));
    }
    
    public function updateRestaurantAction(Request $request)
    {
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
	
	return $this->redirect($this->generateUrl('mnu_main_adminpage'));
    }
}
