<?php

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Mnu\MainBundle\Entity\MenuDishType;


class LoadMenuDishTypeData implements FixtureInterface 
{
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) 
    {        
        $data = split(PHP_EOL, file_get_contents(dirname(__FILE__) . '/menudishtype.txt'));
        
        foreach($data as $key => $menuDishTypeData) 
        {
            $menuDishType = new MenuDishType();
            $menuDishType->setId($key + 1);
            $menuDishType->setType($menuDishTypeData);
            $manager->persist($menuDishType);
        }
        
        // Autorise l'assignation manuelle de l'ID
	$metadata = $manager->getClassMetadata(get_class($menuDishType));
	$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_CUSTOM);
	
        $manager->flush();    
    }
}
