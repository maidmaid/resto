<?php

namespace Mnu\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mnu\UserBundle\Entity\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var type 
     * @ORM\OneToOne(targetEntity="Mnu\MainBundle\Entity\Restaurant", cascade={"persist"})
     */
    private $restaurant;
    
    /**
     * Set id
     *
     * @param integer $id
     * @return User
     */
    public function setId($id)
    {
	$this->id = $id;
	
	return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set restaurant
     *
     * @param \Mnu\MainBundle\Entity\Restaurant $restaurant
     * @return User
     */
    public function setRestaurant(\Mnu\MainBundle\Entity\Restaurant $restaurant = null)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant
     *
     * @return \Mnu\MainBundle\Entity\Restaurant 
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }
}
