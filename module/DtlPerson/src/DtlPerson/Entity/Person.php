<?php

namespace DtlPerson\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlPerson\Entity\Address as AddressEntity;
use DtlPerson\Entity\Contact as ContactEntity;
use DtlPerson\Entity\Individual as IndividualEntity;
use DtlPerson\Entity\Legal as LegalEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class Person {

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint", name="id")
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
     * @ORM\Column(type="boolean", nullable=false)
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
     * @var \DtlPerson\Entity\Address
     */
    protected $address;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Contact", cascade={"all"})
     * @var \DtlPerson\Entity\Contact
     */
    protected $contact;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Individual", cascade={"all"})
     * @var \DtlPerson\Entity\Individual
     */
    protected $individual;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Legal", cascade={"all"})
     * @var \DtlPerson\Entity\Legal
     */
    protected $legal;

    public function __construct() {
        $this->type = false;
        $this->isActive = true;
        $this->date = new \DateTime('now');
        $this->address = new AddressEntity();
        $this->contact = new ContactEntity();
        $this->individual = new IndividualEntity();
        $this->legal = new LegalEntity();
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
        $this->type = $type;
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

    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    public function setContact($contact) {
        $this->contact = $contact;
        return $this;
    }

    public function setIndividual($individual) {
        $this->individual = $individual;
        return $this;
    }

    public function setLegal($legal) {
        $this->legal = $legal;
        return $this;
    }
}
