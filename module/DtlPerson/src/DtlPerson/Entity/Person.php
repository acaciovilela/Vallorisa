<?php

namespace DtlPerson\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class Person {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    protected $type;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var date
     */
    protected $date;

    /**
     * @ORM\Column(type="boolean", name="is_active", nullable=false)
     * @var bool
     */
    protected $isActive;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Address", cascade={"all"})
     * @var Address
     */
    protected $address;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Contact", cascade={"all"})
     * @var Contact
     */
    protected $contact;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Individual", cascade={"all"})
     * @var Individual
     */
    protected $individual;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Legal", cascade={"all"})
     * @var Legal
     */
    protected $legal;

    public function __construct() {
        $this->type = false;
        $this->isActive = true;
        $this->date = new \DateTime('now');
        $this->address = new Address();
        $this->contact = new Contact();
        $this->legal = new Legal();
        $this->individual = new Individual();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getDate() {
        return $this->date;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getContact() {
        return $this->contact;
    }

    public function getIndividual() {
        return $this->individual;
    }

    public function getLegal() {
        return $this->legal;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setType($type) {
        $this->type = (int) $type;
        return $this;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

    public function setAddress(Address $address) {
        $this->address = $address;
        return $this;
    }

    public function setContact(Contact $contact) {
        $this->contact = $contact;
        return $this;
    }

    public function setIndividual(Individual $individual) {
        $this->individual = $individual;
        return $this;
    }

    public function setLegal(Legal $legal) {
        $this->legal = $legal;
        return $this;
    }

}
