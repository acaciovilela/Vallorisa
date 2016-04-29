<?php

namespace DtlProduct\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlProduct\Entity\Category;
use DtlUser\Entity\User;

/**
 * @ORM\Entity(repositoryClass="DtlProduct\Entity\Repository\Product")
 * @ORM\Table(name="product")
 */
class Product {

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
     * @ORM\Column(name="variant_commission", type="decimal", precision=11, scale=2)
     * @var float
     */
    protected $variantCommission;

    /**
     * @ORM\Column(name="fixed_commission", type="decimal", precision=11, scale=2)
     * @var float
     */
    protected $fixedCommission;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @var boolean
     */
    protected $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="DtlProduct\Entity\Category", cascade={"persist"})
     * @var Category 
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity="DtlUser\Entity\User", cascade={"persist"})
     * @var User
     */
    protected $user;

    public function __construct() {
        $this->isActive = true;
        $this->fixedCommission = 0.00;
        $this->variantCommission = 0.00;
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
     * @return float
     */
    function getVariantCommission() {
        return $this->variantCommission;
    }

    /**
     * 
     * @return float
     */
    function getFixedCommission() {
        return $this->fixedCommission;
    }

    /**
     * 
     * @return boolean
     */
    function getIsActive() {
        return $this->isActive;
    }

    /**
     * 
     * @return Category
     */
    function getCategory() {
        return $this->category;
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
     * @param string $variantCommission
     */
    function setVariantCommission($variantCommission) {
        $this->variantCommission = (float) $variantCommission;
    }

    /**
     * 
     * @param float $fixedCommission
     */
    function setFixedCommission($fixedCommission) {
        $this->fixedCommission = (float) $fixedCommission;
    }

    /**
     * 
     * @param boolean $isActive
     */
    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    /**
     * 
     * @param Category $category
     */
    function setCategory(Category $category) {
        $this->category = $category;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

}
