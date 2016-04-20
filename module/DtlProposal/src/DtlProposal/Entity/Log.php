<?php

namespace DtlProposal\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlBank\Entity\Bank;

/**
 * @ORM\Entity
 * @ORM\Table(name="log")
 */
class Log {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $level;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $message;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $timestamp;

    /**
     * @ORM\ManyToOne(targetEntity="DtlBank\Entity\Bank", cascade={"persist"})
     * @var Bank
     */
    protected $bank;

    public function __construct() {
        $this->timestamp = new \DateTime('now');
    }

    /**
     * 
     * @return integer
     */
    function getId() {
        return $this->id;
    }

    /**
     * 
     * @return string
     */
    function getLevel() {
        return $this->level;
    }

    /**
     * 
     * @return string
     */
    function getMessage() {
        return $this->message;
    }

    /**
     * 
     * @return timestamp
     */
    function getTimestamp() {
        return $this->timestamp;
    }

    /**
     * 
     * @return Bank
     */
    function getBank() {
        return $this->bank;
    }

    /**
     * 
     * @param integer $id
     */
    function setId($id) {
        $this->id = $id;
    }

    /**
     * 
     * @param string $level
     */
    function setLevel($level) {
        $this->level = $level;
    }

    /**
     * 
     * @param string $message
     */
    function setMessage($message) {
        $this->message = $message;
    }

    /**
     * 
     * @param timestamp $timestamp
     */
    function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

    /**
     * 
     * @param Bank $bank
     */
    function setBank(Bank $bank) {
        $this->bank = $bank;
    }

}
