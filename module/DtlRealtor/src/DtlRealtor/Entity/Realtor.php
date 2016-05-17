<?php

namespace DtlRealtor\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlPerson\Entity\Person;
use DtlSupplier\Entity\Supplier;
use DtlUser\Entity\User;

/**
 * @ORM\Entity(repositoryClass="DtlRealtor\Entity\Repository\Realtor")
 * @ORM\Table(name="realtor")
 */
class Realtor {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $timestamp;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $commission;

    /**
     * @ORM\Column(name="fixed_commission", type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $fixedCommission;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $bonus;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @var boolean
     */
    protected $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="DtlUser\Entity\User", cascade={"persist"})
     * @var User
     */
    protected $user;

    /**
     * @ORM\OneToOne(targetEntity="DtlSupplier\Entity\Supplier", cascade={"all"})
     * @var Supplier
     */
    protected $supplier;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Person", cascade={"persist", "remove"})
     * @var Person
     */
    protected $person;

    public function __construct() {
        $this->timestamp = new \DateTime("now");
        $this->person = new Person();
        $this->commission = 0.00;
        $this->fixedCommission = 0.00;
        $this->bonus = 0.00;
        $this->isActive = true;
        $this->supplier = new Supplier();
    }

    public function getId() {
        return $this->id;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getCommission() {
        return $this->commission;
    }

    public function getFixedCommission() {
        return $this->fixedCommission;
    }

    public function getBonus() {
        return $this->bonus;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function getUser() {
        return $this->user;
    }

    public function getSupplier() {
        return $this->supplier;
    }

    public function getPerson() {
        return $this->person;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function setCommission($commission) {
        $this->commission = $commission;
        return $this;
    }

    public function setFixedCommission($fixedCommission) {
        $this->fixedCommission = $fixedCommission;
        return $this;
    }

    public function setBonus($bonus) {
        $this->bonus = $bonus;
        return $this;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setSupplier(Supplier $supplier) {
        $this->supplier = $supplier;
        return $this;
    }

    public function setPerson(Person $person) {
        $this->person = $person;
        return $this;
    }
    
    public function getName() {
        return $this->person->getName();
    }

}
