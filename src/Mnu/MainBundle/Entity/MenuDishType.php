<?php

namespace Mnu\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuDishType
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mnu\MainBundle\Entity\MenuDishTypeRepository")
 */
class MenuDishType
{
    /**
     * @ORM\ManyToOne(targetEntity="Mnu\MainBundle\Entity\MenuDish")
     * @ORM\JoinColumn(nullable=false)
     */
    private $menuDish;
    
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
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;
    
    /**
     * Set menuDish
     *
     * @param Mnu\MainBundle\Entity\MenuDish $menuDish
     */
    public function setMenuDish(\Mnu\MainBundle\Entity\MenuDish $menuDish)
    {
        $this->menuDish = $menuDish;
    }

   /**
    * Get menuDish
    *
    * @return Mnu\MainBundle\Entity\MenuDish 
    */
   public function getMenuDish()
   {
     return $this->menuDish;
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
     * Set type
     *
     * @param string $type
     * @return MenuDishType
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
}
