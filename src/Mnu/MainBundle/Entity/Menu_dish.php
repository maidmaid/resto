<?php

namespace Mnu\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu_dish
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mnu\MainBundle\Entity\Menu_dishRepository")
 */
class Menu_dish
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
     * @var integer
     *
     * @ORM\Column(name="id_menu", type="integer")
     */
    private $idMenu;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_dish", type="integer")
     */
    private $idDish;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


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
     * Set idMenu
     *
     * @param integer $idMenu
     * @return Menu_dish
     */
    public function setIdMenu($idMenu)
    {
        $this->idMenu = $idMenu;

        return $this;
    }

    /**
     * Get idMenu
     *
     * @return integer 
     */
    public function getIdMenu()
    {
        return $this->idMenu;
    }

    /**
     * Set idDish
     *
     * @param integer $idDish
     * @return Menu_dish
     */
    public function setIdDish($idDish)
    {
        $this->idDish = $idDish;

        return $this;
    }

    /**
     * Get idDish
     *
     * @return integer 
     */
    public function getIdDish()
    {
        return $this->idDish;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Menu_dish
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
