<?php

namespace Mnu\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Mnu\MainBundle\Entity\Restaurant;

class LoadRestaurantData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
	// Crée une série de User aléatoire
	for ($i = 1; $i <= 100; $i++)
	{
	    $restaurant = $this->createRestaurant($i, 'Restaurant ' . $i);
	    $manager->persist($restaurant);
	}
	
	// Autorise l'assignation manuelle de l'ID
	$metadata = $manager->getClassMetadata(get_class($restaurant));
	$metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_CUSTOM);
	
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
	return 2;
    }
    
    public function createRestaurant($id, $name)
    {
	$restaurant = new Restaurant();
	$restaurant->setId($id);
	$restaurant->setName($name);

	return $restaurant;
    }
}