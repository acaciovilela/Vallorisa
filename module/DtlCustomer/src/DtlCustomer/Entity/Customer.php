<?php

namespace DtlCustomer\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlPerson\Entity\Person;
use DtlUser\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass="DtlCustomer\Entity\Repository\Customer")
 * @ORM\Table(name="customer")
 */
class Customer {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer 
     */
    protected $id;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @var boolean 
     */
    protected $isActive;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $timestamp;

    /**
     * @ORM\Column(name="residence_time", type="string", nullable=true)
     * @var string 
     */
    protected $residenceTime;

    /**
     * @ORM\Column(name="residence_type", type="string", nullable=true);
     * @var string 
     */
    protected $residenceType;

    /**
     * @ORM\Column(name="residence_rent_value", type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $residenceRentValue;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string 
     */
    protected $notes;

    /**
     * @ORM\ManyToOne(targetEntity="DtlUser\Entity\User", cascade={"persist"})
     * @var User 
     */
    protected $user;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Person", cascade={"all"})
     * @var Person
     */
    protected $person;

    /**
     * @ORM\ManyToMany(targetEntity="DtlReference\Entity\Reference", cascade={"all"})
     * @var ArrayCollection
     */
    protected $references;

    /**
     * @ORM\ManyToMany(targetEntity="DtlPatrimony\Entity\Patrimony", cascade={"all"})
     * @var ArrayCollection 
     */
    protected $patrimonies;

    /**
     * @ORM\ManyToMany(targetEntity="DtlBankAccount\Entity\BankAccount", cascade={"all"})
     * @var ArrayCollection 
     */
    protected $accounts;

    /**
     * @ORM\ManyToMany(targetEntity="DtlVehicle\Entity\Vehicle", cascade={"all"})
     * @var ArrayCollection 
     */
    protected $vehicles;

    public function __construct() {
        $this->timestamp = new \DateTime("now");
        $this->residenceRentValue = "0.00";
        $this->person = new Person();
        $this->references = new ArrayCollection();
        $this->patrimonies = new ArrayCollection();
        $this->accounts = new ArrayCollection();
        $this->vehicles = new ArrayCollection();
        $this->isActive = true;
    }

    public function getId() {
        return $this->id;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getResidenceTime() {
        return $this->residenceTime;
    }

    public function getResidenceType() {
        return $this->residenceType;
    }

    public function getResidenceRentValue() {
        return $this->residenceRentValue;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function getUser() {
        return $this->user;
    }

    public function getPerson() {
        return $this->person;
    }

    public function getReferences() {
        return $this->references;
    }

    public function getPatrimonies() {
        return $this->patrimonies;
    }

    public function getAccounts() {
        return $this->accounts;
    }

    public function getVehicles() {
        return $this->vehicles;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function setResidenceTime($residenceTime) {
        $this->residenceTime = $residenceTime;
        return $this;
    }

    public function setResidenceType($residenceType) {
        $this->residenceType = $residenceType;
        return $this;
    }

    public function setResidenceRentValue($residenceRentValue) {
        $this->residenceRentValue = (float) $residenceRentValue;
        return $this;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setPerson(Person $person) {
        $this->person = $person;
        return $this;
    }

    public function setReferences(ArrayCollection $references) {
        $this->references = $references;
        return $this;
    }
    
    public function addReference($reference) {
        $this->references->add($reference);
        return $this;
    }

    public function setPatrimonies(ArrayCollection $patrimonies) {
        $this->patrimonies = $patrimonies;
        return $this;
    }

    public function addPatrimony($patrimony) {
        $this->patrimonies->add($patrimony);
        return $this;
    }


    public function setAccounts(ArrayCollection $accounts) {
        $this->accounts = $accounts;
        return $this;
    }
    
    public function addAccount($account) {
        $this->accounts->add($account);
        return $this;
    }

    public function setVehicles(ArrayCollection $vehicles) {
        $this->vehicles = $vehicles;
        return $this;
    }
    
    public function addVehicle($vehicle) {
        $this->vehicles->add($vehicle);
        return $this;
    }
    
    public function getName() {
        return $this->person->getName();
    }
}
