<?php

namespace Mnu\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="menu_detail")
 */
class MenuDetail
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Mnu\MainBundle\Entity\Menu", inversedBy="details")
     */
    private $menu;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Mnu\MainBundle\Entity\Dish")
     */
    private $dish;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Mnu\MainBundle\Entity\MenuDetailType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;
  
    /**
     * Set Menu
     *
     * @return Menu 
     */
    public function setMenu(\Mnu\MainBundle\Entity\Menu $menu)
    {
        $this->menu = $menu;
    }
    
    /**
     * Get Menu
     *
     * @return Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }
    
    /**
     * Set Dish
     *
     * @return Dish 
     */
    public function setDish(\Mnu\MainBundle\Entity\Dish $dish)
    {
        $this->dish = $dish;
    }
    
    /**
     * Get Dish
     *
     * @return Dish 
     */
    public function getDish()
    {
        return $this->dish;
    }

    /**
     * Set type
     *
     * @param \Mnu\MainBundle\Entity\MenuDetailType $type
     * @return MenuDetail
     */
    public function setType(\Mnu\MainBundle\Entity\MenuDetailType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Mnu\MainBundle\Entity\MenuDetailType 
     */
    public function getType()
    {
        return $this->type;
    }
}
