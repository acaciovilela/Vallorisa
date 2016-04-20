<?php

namespace DtlFinancial\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="discharge")
 */
class Discharge {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="datebr")
     */
    protected $date;
    
    /**
     * @ORM\Column(type="decimal", precision=2)
     */
    protected $Value;
    
    public function __construct() {
        $this->date    = new \DateTime('now');
        $this->value   = 0.00;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getValue() {
        return $this->Value;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function setValue($Value) {
        $this->Value = $Value;
        return $this;
    }
}
