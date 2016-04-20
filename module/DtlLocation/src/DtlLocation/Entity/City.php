<?php

namespace DtlLocation\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlLocation\Entity\State;

/**
 * @ORM\Entity
 * @ORM\Table(name="city")
 */
class City {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string 
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="DtlLocation\Entity\State", cascade={"persist"})
     * @var State 
     */
    protected $state;

    public function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getCode() {
        return $this->code;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setName($name) {
        $this->name = $name;
        return $this;
    }

    function setCode($code) {
        $this->code = $code;
        return $this;
    }
    
    function getState() {
        return $this->state;
    }

    function setState(State $state) {
        $this->state = $state;
        return $this;
    }
}
