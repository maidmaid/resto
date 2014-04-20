<?php

namespace Mnu\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="menu_dish")
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
     * @ORM\ManyToOne(targetEntity="Mnu\MainBundle\Entity\MenuDishType")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(name="menu_dish_type_id")
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
     * @param \Mnu\MainBundle\Entity\MenuDishType $type
     * @return MenuDish
     */
    public function setType(\Mnu\MainBundle\Entity\MenuDishType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Mnu\MainBundle\Entity\MenuDishType 
     */
    public function getType()
    {
        return $this->type;
    }
}
