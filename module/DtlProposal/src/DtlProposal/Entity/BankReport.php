<?php

namespace DtlProposal\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bank_report")
 */
class BankReport {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;
    
    /**
     * @ORM\ManyToOne(targetEntity="DtlBank\Entity\Bank", cascade={"persist"})
     */
    protected $bank;
    
    public function __construct() {
        $this->isActive = true;
    }
    
    function getId() {
        return $this->id;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getBank() {
        return $this->bank;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setBank($bank) {
        $this->bank = $bank;
    }
}
