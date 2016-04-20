<?php

namespace DtlLocation\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlLocation\Entity\Country;

/**
 * @ORM\Entity
 * @ORM\Table(name="state")
 */
class State {

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
     * @ORM\Column(type="string")
     * @var string 
     */
    protected $code;
    
    /**
     * @ORM\ManyToOne(targetEntity="DtlLocation\Entity\Country", cascade={"persist"})
     * @var Country 
     */
    protected $country;

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
    
    function getCountry() {
        return $this->country;
    }

    function setCountry(Country $country) {
        $this->country = $country;
        return $this;
    }
}
