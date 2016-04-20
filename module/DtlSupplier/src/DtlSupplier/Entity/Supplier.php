<?php

namespace DtlSupplier\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlPerson\Entity\Person;
use DtlUser\Entity\User;

/**
 * @ORM\Entity(repositoryClass="DtlSupplier\Entity\Repository\Supplier")
 * @ORM\Table(name="supplier")
 */
class Supplier {

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
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;

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

    public function getIsActive() {
        return $this->isActive;
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

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
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
