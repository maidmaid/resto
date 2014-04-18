<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Mnu\MainBundle\Entity\Dish;


class LoadDishData implements FixtureInterface, OrderedFixtureInterface
{
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) 
    {        
        $data = split(PHP_EOL, file_get_contents(dirname(__FILE__) . '/dish.txt'));
        
        foreach($data as $key => $dishData) 
        {
            $dish = new Dish();
            $dish->setId($key + 1);
            $dish->setEntitled($dishData);
            $manager->persist($dish);
        }
        
        // Autorise l'assignation manuelle de l'ID
	$metadata = $manager->getClassMetadata(get_class($dish));
	$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_CUSTOM);
	
        $manager->flush();    
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() 
    {
        return 5;
    }
}
