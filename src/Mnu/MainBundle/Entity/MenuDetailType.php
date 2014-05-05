<?php

namespace Mnu\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuDishType
 *
 * @ORM\Table(name="menu_detail_type")
 * @ORM\Entity(repositoryClass="Mnu\MainBundle\Entity\MenuDetailTypeRepository")
 */
class MenuDetailType
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
    private $name;
    
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
     * Set name
     *
     * @param string $name
     * @return MenuDetailType
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
}
