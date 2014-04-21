<?php

namespace Mnu\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Mnu\MainBundle\Entity\Menu;
use Mnu\MainBundle\Entity\Restaurant;
use Mnu\MainBundle\Entity\RestaurantRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadMenuData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
	/* @var $repository RestaurantRepository */
        $repository = $this->container->get('doctrine')->getRepository('MnuMainBundle:Restaurant');
	
        /* @var $users Restaurant[] */
	$restaurants = $repository->findAll();
	
	foreach($restaurants as $key => $restaurant)
	{
            // génération de 1 à 5 menus max par restaurant
            foreach (range(1, rand(1,5)) as $number) {
                $menu = new Menu();
                $menu->setEntitled('Menu N° '.$number)
                        ->setImage('image'.$number.'.jpg')
                        ->setPrice(mt_rand (15*10, 100*10) / 10) // définit le prix d'un menu entre CHF 15 et CHF 100 avec décimales
                        ->setRestaurant($restaurant);

                $manager->persist($menu);  
            }   
	}
        
	// Autorise l'assignation manuelle de l'ID
	$metadata = $manager->getClassMetadata(get_class($menu));
	$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_CUSTOM);
	
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
	return 4;
    }
}