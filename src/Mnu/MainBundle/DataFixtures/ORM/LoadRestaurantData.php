<?php

namespace Mnu\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Mnu\MainBundle\Entity\Restaurant;
use Mnu\UserBundle\Entity\User;
use Mnu\UserBundle\Entity\UserRepository;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
	$data = split(PHP_EOL, file_get_contents(dirname(__FILE__) . '/restaurant.txt'));
	
	/* @var $repository UserRepository */
	$repository = $this->container->get('doctrine')->getRepository('MnuUserBundle:User');
	/* @var $users User[] */
	$users = $repository->findAll();
	
	foreach($users as $key => $user)
	{
	    $restaurant = new Restaurant();
	    $restaurant->setId($key + 1);
	    $restaurant->setName($data[$key]);

	    $user->setRestaurant($restaurant);
	    $manager->persist($user);
	}
	
	// Autorise l'assignation manuelle de l'ID
	$metadata = $manager->getClassMetadata(get_class($restaurant));
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
	return 2;
    }
}