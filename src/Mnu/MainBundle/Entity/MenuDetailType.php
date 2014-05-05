<?php

namespace Mnu\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuDishType
 *
 * @ORM\Table(name="menu_dish_type")
 * @ORM\Entity(repositoryClass="Mnu\MainBundle\Entity\MenuDishTypeRepository")
 */
class MenuDishType
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
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;
    
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
