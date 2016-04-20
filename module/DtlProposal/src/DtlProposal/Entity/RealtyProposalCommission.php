<?php

namespace DtlProposal\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="realty_proposal_commission")
 */
class RealtyProposalCommission {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     * @var float
     */
    protected $value;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @var boolean
     */
    protected $isActive;

    public function __construct() {
        $this->value = 0.00;
        $this->isActive = true;
    }

    function getId() {
        return $this->id;
    }

    function getValue() {
        return $this->value;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setValue($value) {
        $this->value = $value;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

}
