<?php

namespace DtlSeller\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlPerson\Entity\Person;

/**
 * @ORM\Entity(repositoryClass="DtlSeller\Entity\Repository\Seller")
 * @ORM\Table(name="seller")
 */
class Seller {

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $timestamp;
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Person", cascade={"persist", "remove"})
     * @var Person
     */
    protected $person;

    public function __construct() {
        $this->timestamp = new \DateTime("now");
        $this->person = new Person();
        $this->isActive = true;
    }

    public function getId() {
        return $this->id;
    }

    public function getTimestamp() {
        return $this->timestamp;
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

    public function setPerson(Person $person) {
        $this->person = $person;
        return $this;
    }
    
    function getIsActive() {
        return $this->isActive;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return string Name
     */
    public function getName() {
        return $this->person->getName();
    }
}
