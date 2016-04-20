<?php

namespace DtlProposal\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlBank\Entity\Bank;

/**
 * @ORM\Entity
 * @ORM\Table(name="realty_evaluation")
 */
class RealtyEvaluation {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer 
     */
    protected $id;

    /**
     * @ORM\Column(name="request_date", type="datebr")
     * @var date 
     */
    protected $requestDate;

    /**
     * @ORM\Column(name="completion_date", type="datebr", nullable=true)
     * @var date
     */
    protected $completionDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string 
     */
    protected $engineering;

    /**
     * @ORM\Column(name="engineering_phone", type="string", nullable=true)
     * @var string
     */
    protected $engineeringPhone;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $engineer;

    /**
     * @ORM\Column(name="engineer_phone", type="string", nullable=true)
     * @var string 
     */
    protected $engineerPhone;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     * @var float 
     */
    protected $value;

    /**
     * @ORM\OneToOne(targetEntity="DtlBank\Entity\Bank", cascade={"persist"})
     * @var Bank 
     */
    protected $bank;

    public function __construct() {
        $this->requestDate = new \DateTime('now');
        $this->completionDate = null;
        $this->value = 0.00;
    }

    function getId() {
        return $this->id;
    }

    function getRequestDate() {
        return $this->requestDate;
    }

    function getCompletionDate() {
        return $this->completionDate;
    }

    function getEngineering() {
        return $this->engineering;
    }

    function getEngineeringPhone() {
        return $this->engineeringPhone;
    }

    function getEngineer() {
        return $this->engineer;
    }

    function getEngineerPhone() {
        return $this->engineerPhone;
    }

    function getValue() {
        return $this->value;
    }

    function getBank() {
        return $this->bank;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setRequestDate($requestDate) {
        $this->requestDate = $requestDate;
    }

    function setCompletionDate($completionDate) {
        $this->completionDate = $completionDate;
    }

    function setEngineering($engineering) {
        $this->engineering = $engineering;
    }

    function setEngineeringPhone($engineeringPhone) {
        $this->engineeringPhone = $engineeringPhone;
    }

    function setEngineer($engineer) {
        $this->engineer = $engineer;
    }

    function setEngineerPhone($engineerPhone) {
        $this->engineerPhone = $engineerPhone;
    }

    function setValue($value) {
        $this->value = $value;
    }

    function setBank(Bank $bank) {
        $this->bank = $bank;
    }

}
