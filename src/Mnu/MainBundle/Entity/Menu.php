<?php

namespace Mnu\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mnu\MainBundle\Entity\MenuRepository")
 */
class Menu
{
    /**
     * @ORM\ManyToOne(targetEntity="Mnu\MainBundle\Entity\Restaurant", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurant;
  
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="entitled", type="string", length=60, nullable=true)
     */
    private $entitled;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", scale=2)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=45)
     */
    private $image;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Mnu\MainBundle\Entity\MenuDetail", mappedBy="menu")
     */
    private $details;
    
    /**
     * @param Mnu\MainBundle\Entity\Restaurant $restaurant
     */
    public function setRestaurant(\Mnu\MainBundle\Entity\Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }
   
    /**
     * @return Mnu\MainBundle\Entity\Restaurant 
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return integer
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
     * Set entitled
     *
     * @param string $entitled
     * @return Menu
     */
    public function setEntitled($entitled)
    {
        $this->entitled = $entitled;

        return $this;
    }

    /**
     * Get entitled
     *
     * @return string 
     */
    public function getEntitled()
    {
        return $this->entitled;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Menu
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Menu
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->details = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add details
     *
     * @param \Mnu\MainBundle\Entity\MenuDetail $details
     * @return Menu
     */
    public function addDetail(\Mnu\MainBundle\Entity\MenuDetail $details)
    {
        $this->details[] = $details;

        return $this;
    }

    /**
     * Remove details
     *
     * @param \Mnu\MainBundle\Entity\MenuDetail $details
     */
    public function removeDetail(\Mnu\MainBundle\Entity\MenuDetail $details)
    {
        $this->details->removeElement($details);
    }

    /**
     * Get details
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDetails()
    {
        return $this->details;
    }
}
