<?php

namespace DtlBankAccount\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlBank\Entity\Bank;

/**
 * @ORM\Entity
 * @ORM\Table(name="bank_account")
 */
class BankAccount {

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
    protected $type;

    /**
     * @ORM\Column(name="bank_name", type="string", nullable=true)
     * @var string
     */
    protected $bankName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $agency;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $account;

    /**
     * @ORM\Column(type="datebr", nullable=true)
     */
    protected $since;

    /**
     * @ORM\ManyToOne(targetEntity="DtlBank\Entity\Bank", cascade={"persist"})
     * @var Bank 
     */
    protected $bank;

    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }

    public function getBankName() {
        return $this->bankName;
    }

    public function getAgency() {
        return $this->agency;
    }

    public function getAccount() {
        return $this->account;
    }

    public function getSince() {
        return $this->since;
    }

    public function getBank() {
        return $this->bank;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setBankName($bankName) {
        $this->bankName = $bankName;
        return $this;
    }

    public function setAgency($agency) {
        $this->agency = $agency;
        return $this;
    }

    public function setAccount($account) {
        $this->account = $account;
        return $this;
    }

    public function setSince($since) {
        $this->since = $since;
        return $this;
    }

    public function setBank(Bank $bank) {
        $this->bank = $bank;
        return $this;
    }

}
