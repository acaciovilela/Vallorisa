<?php

namespace DtlCurrentAccount\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="credit_card")
 */
class CreditCard {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $number;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $brand;

    /**
     * @ORM\Column(type="integer")
     */
    protected $closing;

    /**
     * @ORM\Column(type="integer")
     */
    protected $expiration;

    /**
     * @ORM\Column(type="string")
     */
    protected $validity;

    public function getId() {
        return $this->id;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function getClosing() {
        return $this->closing;
    }

    public function getExpiration() {
        return $this->expiration;
    }

    public function getValidity() {
        return $this->validity;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setNumber($number) {
        $this->number = $number;
        return $this;
    }

    public function setBrand($brand) {
        $this->brand = $brand;
        return $this;
    }

    public function setClosing($closing) {
        $this->closing = $closing;
        return $this;
    }

    public function setExpiration($expiration) {
        $this->expiration = $expiration;
        return $this;
    }

    public function setValidity($validity) {
        $this->validity = $validity;
        return $this;
    }

}
