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
	    $menu = new Menu();
            $menu->setEntitled('test')
                    ->setImage('image')
                    ->setPrice(45.5)
                    ->setRestaurant($restaurant);
                    
	    $manager->persist($menu);
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