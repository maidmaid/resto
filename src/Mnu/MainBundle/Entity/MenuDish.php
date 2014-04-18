<?php

namespace Mnu\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class MenuDish
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Mnu\MainBundle\Entity\Menu")
     */
    private $menu;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Mnu\MainBundle\Entity\Dish")
     */
    private $dish;
  
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
}
