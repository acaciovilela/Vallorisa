<?php

namespace DtlDealer\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlPerson\Entity\Person;

/**
 * @ORM\Entity(repositoryClass="DtlDealer\Entity\Repository\Dealer")
 * @ORM\Table(name="dealer")
 */
class Dealer {

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Person", cascade={"all"})
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

    public function setPerson($person) {
        $this->person = $person;
        return $this;
    }

}
