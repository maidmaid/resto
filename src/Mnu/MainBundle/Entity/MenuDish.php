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
     * @var enum
     *
     * @ORM\Column(name="$type", type="string", columnDefinition="enum('Entrée', 'Plat principal', 'Dessert')")
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
     * @param enum $type
     * @return MenuDish
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    
    /**
     * Get type
     *
     * @return enum 
     */
    public function getType()
    {
        return $this->type;
    }
}
