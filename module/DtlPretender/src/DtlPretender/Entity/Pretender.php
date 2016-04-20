<?php

namespace DtlPretender\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlPerson\Entity\Person;
use DtlUser\Entity\User;
use DtlRealty\Entity\RealtyType;

/**
 * @ORM\Entity(repositoryClass="DtlPretender\Entity\Repository\Pretender")
 * @ORM\Table(name="pretender")
 */
class Pretender {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $timestamp;

    /**
     * @ORM\ManyToOne(targetEntity="DtlRealty\Entity\RealtyType", cascade={"persist"})
     * @var RealtyType
     */
    protected $realtyType;

    /**
     * @ORM\Column(name="realty_value", type="decimal", precision=11, scale=2, nullable=true)
     */
    protected $realtyValue;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     */
    protected $value;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;

    /**
     * @ORM\Column(type="string", nullable=true)
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

    public function getRealtyType() {
        return $this->realtyType;
    }

    public function getRealtyValue() {
        return $this->realtyValue;
    }

    public function getValue() {
        return $this->value;
    }

    public function getIsActive() {
        return $this->isActive;
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

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function setRealtyType(RealtyType $realtyType) {
        $this->realtyType = $realtyType;
        return $this;
    }

    public function setRealtyValue($realtyValue) {
        $this->realtyValue = (float) $realtyValue;
        return $this;
    }

    public function setValue($value) {
        $this->value = (float) $value;
        return $this;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
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

}
