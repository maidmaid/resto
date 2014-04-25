<?php

namespace Mnu\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mnu\MainBundle\Entity\DishRepository;
use Mnu\MainBundle\Entity\MenuRepository;
use Mnu\MainBundle\Entity\Restaurant;
use Mnu\MainBundle\Entity\MenuDish;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadMenuDishData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface 
     */
    private $container;
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
	/* @var $repositoryMenu MenuRepository */
        $repositoryMenu = $this->container->get('doctrine')->getRepository('MnuMainBundle:Menu');
        /* @var $menus Restaurant[] */
	$menus = $repositoryMenu->findAll();
        
        /* @var $repositoryDish DishRepository */
        $repositoryDish = $this->container->get('doctrine')->getRepository('MnuMainBundle:Dish');
        /* @var $dishes Restaurant[] */
	$dishes = $repositoryDish->findAll();
        
        /* @var $repositoryMenuDishType DishTypeRepository */
        $repositoryMenuDishType = $this->container->get('doctrine')->getRepository('MnuMainBundle:MenuDishType');
        /* @var $dishTypes Restaurant[] */
	$menuDishTypes = $repositoryMenuDishType->findAll();
        
	foreach($menus as $key => $menu)
	{
	    $randMenuDishTypes = array_rand($menuDishTypes, rand(2, count($menuDishTypes) - 1));

	    for ($i = 0; $i < count($randMenuDishTypes); $i++)
	    {
		$menuDish = new MenuDish();
		$menuDish->setMenu($menu);
		$menuDish->setDish($dishes[array_rand($dishes)]);
		$menuDish->setMenuDishType($menuDishTypes[$randMenuDishTypes[$i]]);
		
		$manager->persist($menuDish);
	    }
	}
       
	
	$manager->flush();
    }
    
    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
	$this->container = $container;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
	return 6;
    }
}