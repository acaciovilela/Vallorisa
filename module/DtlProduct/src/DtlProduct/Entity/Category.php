<?php

namespace DtlProduct\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlUser\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var integer
     */
    protected $parent;

    /**
     * @ORM\ManyToOne(targetEntity="DtlUser\Entity\User")
     */
    protected $user;

    public function __construct() {
        $this->parent = null;
    }

    /**
     * 
     * @return integer
     */
    function getId() {
        return $this->id;
    }

    /**
     * 
     * @return string
     */
    function getName() {
        return $this->name;
    }

    /**
     * 
     * @return string
     */
    function getType() {
        return $this->type;
    }

    /**
     * 
     * @return Category
     */
    function getParent() {
        return $this->parent;
    }

    /**
     * 
     * @return User
     */
    function getUser() {
        return $this->user;
    }

    /**
     * 
     * @param integer $id
     */
    function setId($id) {
        $this->id = $id;
    }

    /**
     * 
     * @param string $name
     */
    function setName($name) {
        $this->name = $name;
    }

    /**
     * 
     * @param string $type
     */
    function setType($type) {
        $this->type = $type;
    }

    /**
     * 
     * @param Category $parent
     */
    function setParent(Category $parent) {
        $this->parent = $parent;
    }

    /**
     * 
     * @param User $user
     */
    function setUser(User $user) {
        $this->user = $user;
    }

}
