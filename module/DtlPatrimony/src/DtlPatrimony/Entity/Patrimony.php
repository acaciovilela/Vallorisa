<?php

namespace DtlPatrimony\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="patrimony")
 */
class Patrimony {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     */
    protected $value;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     */
    protected $debit;

    public function __construct() {
        $this->value = 0.00;
        $this->debit = 0.00;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getValue() {
        return $this->value;
    }

    public function getDebit() {
        return $this->debit;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setDebit($debit) {
        $this->debit = $debit;
        return $this;
    }

}
