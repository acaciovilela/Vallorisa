<?php

namespace DtlShopman\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DtlPerson\Entity\Person;
use DtlSeller\Entity\Seller;
use DtlProduct\Entity\Product;
use DtlUser\Entity\User;

/**
 * @ORM\Entity(repositoryClass="DtlShopman\Entity\Repository\Shopman")
 * @ORM\Table(name="shopman")
 */
class Shopman {

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer 
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     * @var timestamp 
     */
    protected $timestamp;

    /**
     * @ORM\Column(name="variant_comission", type="decimal", precision=11, scale=2)
     * @var float 
     */
    protected $variantComission;

    /**
     * @ORM\Column(name="fixed_comission", type="decimal", precision=11, scale=2)
     */
    protected $fixedComission;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="\DtlUser\Entity\User", cascade={"persist"})
     * @var User 
     */
    protected $user;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Person", cascade={"all"})
     * @var Person
     */
    protected $person;

    /**
     * @ORM\ManyToMany(targetEntity="DtlSeller\Entity\Seller", cascade={"all"})
     * @var ArrayCollection
     */
    protected $sellers;

    /**
     * @ORM\ManyToMany(targetEntity="DtlProduct\Entity\Product", cascade="persist")
     * @var ArrayCollection 
     */
    protected $products;

    public function __construct() {
        $this->timestamp = new \DateTime("now");
        $this->person = new Person();
        $this->variantComission = 0.00;
        $this->fixedComission = 0.00;
        $this->isActive = true;
        $this->sellers = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    /**
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @return timestamp
     */
    public function getTimestamp() {
        return $this->timestamp;
    }

    /**
     * 
     * @return float
     */
    public function getVariantComission() {
        return $this->variantComission;
    }

    /**
     * 
     * @return float
     */
    public function getFixedComission() {
        return $this->fixedComission;
    }

    /**
     * 
     * @return boolean
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * 
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * 
     * @return Person
     */
    public function getPerson() {
        return $this->person;
    }

    /**
     * 
     * @return ArrayCollection
     */
    public function getSellers() {
        return $this->sellers;
    }

    /**
     * 
     * @return ArrayCollection
     */
    public function getProducts() {
        return $this->products;
    }

    /**
     * 
     * @param integer $id
     * @return \DtlShopman\Entity\Shopman
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     * @param timestamp $timestamp
     * @return \DtlShopman\Entity\Shopman
     */
    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * 
     * @param float $variantComission
     * @return \DtlShopman\Entity\Shopman
     */
    public function setVariantComission($variantComission) {
        $this->variantComission = $variantComission;
        return $this;
    }

    /**
     * 
     * @param float $fixedComission
     * @return \DtlShopman\Entity\Shopman
     */
    public function setFixedComission($fixedComission) {
        $this->fixedComission = $fixedComission;
        return $this;
    }

    /**
     * 
     * @param boolean $isActive
     * @return \DtlShopman\Entity\Shopman
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * 
     * @param User $user
     * @return \DtlShopman\Entity\Shopman
     */
    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    /**
     * 
     * @param Person $person
     * @return \DtlShopman\Entity\Shopman
     */
    public function setPerson(Person $person) {
        $this->person = $person;
        return $this;
    }

    /**
     * 
     * @param ArrayCollection $sellers
     * @return \DtlShopman\Entity\Shopman
     */
    public function setSellers(ArrayCollection $sellers) {
        foreach ($sellers as $seller) {
            $this->addSeller($seller);
        }
        return $this;
    }

    /**
     * 
     * @param Seller $seller
     * @return \DtlShopman\Entity\Shopman
     */
    public function addSeller(Seller $seller) {
        $this->sellers->add($seller);
        return $this;
    }

    /**
     * 
     * @param Seller $seller
     * @return \DtlShopman\Entity\Shopman
     */
    public function removeSeller(Seller $seller) {
        $this->sellers->removeElement($seller);
        return $this;
    }

    /**
     * 
     * @param ArrayCollection $products
     * @return \DtlShopman\Entity\Shopman
     */
    public function setProducts(ArrayCollection $products) {
        foreach ($products as $product) {
            $this->addProduct($product);
        }
        return $this;
    }

    /**
     * 
     * @param Product $product
     * @return \DtlShopman\Entity\Shopman
     */
    public function addProduct(Product $product) {
        $this->products->add($product);
        return $this;
    }

    /**
     * 
     * @param Product $product
     * @return \DtlShopman\Entity\Shopman
     */
    public function removeProduct(Product $product) {
        $this->products->removeElement($product);
        return $this;
    }

    /**
     * @return string Name
     */
    public function getName() {
        return $this->person->getName();
    }
}
