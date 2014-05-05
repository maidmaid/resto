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

class LoadMenuDetailData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $repositoryMenuDetailType = $this->container->get('doctrine')->getRepository('MnuMainBundle:MenuDetailType');
        /* @var $dishTypes Restaurant[] */
	$menuDetailTypes = $repositoryMenuDetailType->findAll();
        
	foreach($menus as $key => $menu)
	{
	    $randMenuDetailTypes = array_rand($menuDetailTypes, rand(2, count($menuDetailTypes) - 1));

	    for ($i = 0; $i < count($randMenuDetailTypes); $i++)
	    {
		$menuDetail = new \Mnu\MainBundle\Entity\MenuDetail();
		$menuDetail->setMenu($menu);
		$menuDetail->setDish($dishes[array_rand($dishes)]);
		$menuDetail->setType($menuDetailTypes[$randMenuDetailTypes[$i]]);
		
		$manager->persist($menuDetail);
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