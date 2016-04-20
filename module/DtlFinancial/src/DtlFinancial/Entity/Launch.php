<?php

namespace DtlFinancial\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlCurrentAccount\Entity\CurrentAccount;
use DtlAccountingItem\Entity\AccountingItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="launch")
 */
class Launch {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     * @var date
     */
    protected $date;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $number;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $value;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="DtlCurrentAccount\Entity\CurrentAccount", cascade={"persist"})
     * @var CurrentAccount
     */
    protected $currentAccount;

    /**
     * @ORM\ManyToOne(targetEntity="DtlAccountingItem\Entity\AccountingItem", cascade={"persist"})
     * @var AccountingItem
     */
    protected $accountingItem;

    public function __construct() {
        $this->date = new \DateTime('now');
        $this->value = 0.00;
    }

    public function getId() {
        return $this->id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getValue() {
        return $this->value;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCurrentAccount() {
        return $this->currentAccount;
    }

    public function getAccountingItem() {
        return $this->accountingItem;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function setNumber($number) {
        $this->number = $number;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setCurrentAccount(CurrentAccount $currentAccount) {
        $this->currentAccount = $currentAccount;
        return $this;
    }

    public function setAccountingItem(AccountingItem $accountingItem) {
        $this->accountingItem = $accountingItem;
        return $this;
    }
}
