<?php

namespace DtlCollections\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="slave")
 */
class Slave {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="People", cascade={"all"})
     */
    protected $people;

    public function __construct() {
        $this->people = new People();
    }

    public function getId() {
        return $this->id;
    }

    public function getPeople() {
        return $this->people;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setPeople($people) {
        $this->people = $people;
        return $this;
    }

}
