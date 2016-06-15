<?php

namespace DtlDealer\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlPerson\Entity\Person;

/**
 * @ORM\Entity
 * @ORM\Table(name="dealer")
 */
class Dealer {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Person", cascade={"all"}, orphanRemoval=true)
     * @var Person
     */
    protected $person;

    public function __construct() {
        $this->person = new Person();
    }

    public function getId() {
        return $this->id;
    }

    public function getPerson() {
        return $this->person;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setPerson(Person $person) {
        $this->person = $person;
        return $this;
    }

}
