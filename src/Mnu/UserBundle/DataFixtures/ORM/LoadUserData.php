<?php

namespace Mnu\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Mnu\UserBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
	    $user = $this->createUser($i, 'Resto' . $i, 'resto'.$i.'@gmail.com', 'restopass' . $i);
	    $manager->persist($user);
	}
	
	// Crée des utilisateurs spécifiques
	$user = $this->createUser($i++, 'Dany', 'danymaillard93b@gmail.com', 'danypass');
	$manager->persist($user);
	$user = $this->createUser($i++, 'Vincent', 'vincent.huck.pro@gmail.com', 'vincentpass');
	$manager->persist($user);
	$user = $this->createUser($i++, 'Thierry', 'crettolthierry@ringtarget.com', 'thierrypass');
	$manager->persist($user);
	
	// Autorise l'assignation manuelle de l'ID
	$metadata = $manager->getClassMetadata(get_class($user));
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
	return 1;
    }
    
    /**
     * Crée un utilisateur
     * @param string $username
     * @param string $email
     * @param string $password
     * @return \Mnu\UserBundle\Entity\User
     */
    public function createUser($id, $username, $email, $password)
    {
	$user = new User();
	$user->setId($id);
	$user->setUsername($username);
	$user->setEmail($email);
	$user->setEnabled(true);
	
	// Encode le mot de passe
	/* @var $encoderFactory \Symfony\Component\Security\Core\Encoder\EncoderFactory */
	$encoderFactory = $this->container->get('security.encoder_factory');
	$encoder = $encoderFactory->getEncoder($user);
	$passwordEncoded = $encoder->encodePassword($password, $user->getSalt());
	$user->setPassword($passwordEncoded);
	
	return $user;
    }
}