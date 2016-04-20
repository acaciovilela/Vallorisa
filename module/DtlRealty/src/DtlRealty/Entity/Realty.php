<?php

namespace DtlRealty\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlPerson\Entity\Address;

/**
 * @ORM\Entity
 * @ORM\Table(name="realty")
 */
class Realty {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true, nullable=true)
     * @var string
     */
    protected $code;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $notes;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     * @var float
     */
    protected $value;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $timestamp;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Address", cascade={"all"})
     * @var \DtlPerson\Entity\Address
     */
    protected $address;

    /**
     * @ORM\OneToOne(targetEntity="DtlRealty\Entity\RealtyFeature", cascade={"all"})
     * @var \DtlRealty\Entity\RealtyFeature
     */
    protected $feature;

    /**
     * @ORM\ManyToOne(targetEntity="DtlRealty\Entity\RealtyType", cascade={"persist"})
     * @var RealtyType
     */
    protected $type;

    public function __construct() {
        $this->timestamp = new \DateTime('now');
        $this->value = 0.00;
    }

    public function getId() {
        return $this->id;
    }

    public function getCode() {
        return $this->code;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function getValue() {
        return $this->value;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getFeature() {
        return $this->feature;
    }

    public function getType() {
        return $this->type;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function setAddress(Address $address) {
        $this->address = $address;
        return $this;
    }

    public function setFeature(\DtlRealty\Entity\RealtyFeature $feature) {
        $this->feature = $feature;
        return $this;
    }

    public function setType(RealtyType $type) {
        $this->type = $type;
        return $this;
    }

}
