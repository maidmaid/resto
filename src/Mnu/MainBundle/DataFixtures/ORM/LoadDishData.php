<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mnu\MainBundle\Entity\Dish;
use Doctrine\ORM\Mapping\ClassMetadata;


class LoadDishData implements FixtureInterface {
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {        
        $data = split(PHP_EOL, file_get_contents(dirname(__FILE__) . '/dish.txt'));
        
        foreach($data as $key => $dishData) {
            $dish = new Dish();
            $dish->setId($key);
            $dish->setEntitled($dishData);
            $manager->persist($dish);
        }
        
        // Autorise l'assignation manuelle de l'ID
	$metadata = $manager->getClassMetadata(get_class($dish));
	$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_CUSTOM);
	
        $manager->flush();    
    }
}
