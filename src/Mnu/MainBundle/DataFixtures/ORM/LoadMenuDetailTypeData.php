<?php

namespace Mnu\MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Mnu\MainBundle\Entity\MenuDetailType;


class LoadMenuDetailTypeData implements FixtureInterface, OrderedFixtureInterface
{
    
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) 
    {        
        $data = split(PHP_EOL, file_get_contents(dirname(__FILE__) . '/menudetailtype.txt'));
        
        foreach($data as $key => $menuDetailTypeData) 
        {
            $menuDetailType = new MenuDetailType();
            $menuDetailType->setId($key + 1);
            $menuDetailType->setName($menuDetailTypeData);
            $manager->persist($menuDetailType);
        }
        
        // Autorise l'assignation manuelle de l'ID
	$metadata = $manager->getClassMetadata(get_class($menuDetailType));
	$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_CUSTOM);
	
        $manager->flush();    
    }

    public function getOrder() 
    {
        return 3;
    }
}
