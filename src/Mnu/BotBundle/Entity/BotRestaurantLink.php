<?php

namespace Mnu\BotBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BotRestaurantLink
 *
 * @ORM\Table(name="bot_restaurant_link")
 * @ORM\Entity(repositoryClass="Mnu\BotBundle\Entity\BotRestaurantLinkRepository")
 */
class BotRestaurantLink
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
    
    /**
     * @var \Mnu\BotBundle\Entity\BotRestaurant
     * 
     * @ORM\ManyToOne(targetEntity="Mnu\BotBundle\Entity\BotRestaurant", inversedBy="links")
     */
    private $botRestaurant;

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
     * Set url
     *
     * @param string $url
     * @return BotRestaurantLink
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set botRestaurant
     *
     * @param \Mnu\BotBundle\Entity\BotRestaurant $botRestaurant
     * @return BotRestaurantLink
     */
    public function setBotRestaurant(\Mnu\BotBundle\Entity\BotRestaurant $botRestaurant = null)
    {
        $this->botRestaurant = $botRestaurant;

        return $this;
    }

    /**
     * Get botRestaurant
     *
     * @return \Mnu\BotBundle\Entity\BotRestaurant 
     */
    public function getBotRestaurant()
    {
        return $this->botRestaurant;
    }
}
