<?php

namespace Mnu\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BotRestaurant
 *
 * @ORM\Table(name="bot_restaurant")
 * @ORM\Entity(repositoryClass="Mnu\BotBundle\Entity\BotRestaurantRepository")
 */
class BotRestaurant
{
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
     * @ORM\Column(name="number", type="string", length=10)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \Mnu\BotBundle\Entity\BotRestaurantLink[]
     * 
     * @ORM\OneToMany(targetEntity="Mnu\BotBundle\Entity\BotRestaurantLink", mappedBy="botRestaurant", cascade={"persist"})
     */
    private $links;

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
     * Set number
     *
     * @param string $number
     * @return BotRestaurant
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return BotRestaurant
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->links = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add links
     *
     * @param \Mnu\BotBundle\Entity\BotRestaurantLink $links
     * @return BotRestaurant
     */
    public function addLink(\Mnu\BotBundle\Entity\BotRestaurantLink $links)
    {
        $this->links[] = $links;

        return $this;
    }

    /**
     * Remove links
     *
     * @param \Mnu\BotBundle\Entity\BotRestaurantLink $links
     */
    public function removeLink(\Mnu\BotBundle\Entity\BotRestaurantLink $links)
    {
        $this->links->removeElement($links);
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLinks()
    {
        return $this->links;
    }
    
    public function linkExists($url)
    {
        foreach ($this->links as $link)
        {
            if($link->getUrl() == $url)
            {
                return true;
            }
        }
        
        return false;
    }
}
