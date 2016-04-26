<?php

namespace DtlBank\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bank")
 */
class Bank {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $code;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $url;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $tax;

    /**
     * @ORM\Column(name="return_value", type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $returnValue;

    /**
     * @ORM\Column(type="boolean")
     * @var float
     */
    protected $direct;

    public function __construct() {
        $this->direct = false;
    }

    public function getId() {
        return $this->id;
    }

    public function getCode() {
        return $this->code;
    }

    public function getName() {
        return $this->name;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getTax() {
        return $this->tax;
    }

    public function getReturnValue() {
        return $this->returnValue;
    }

    public function getDirect() {
        return $this->direct;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function setTax($tax) {
        $this->tax = $tax;
        return $this;
    }

    public function setReturnValue($returnValue) {
        $this->returnValue = $returnValue;
        return $this;
    }

    public function setDirect($direct) {
        $this->direct = $direct;
        return $this;
    }

}
