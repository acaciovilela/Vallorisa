<?php

namespace DtlFinancial\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlCurrentAccount\Entity\CurrentAccount;
use DtlPaymentType\Entity\PaymentType;
use DtlAccountingItem\Entity\AccountingItem;
use DtlDocumentType\Entity\DocumentType;

/**
 * @ORM\Entity
 * @ORM\Table(name="account")
 */
class Account {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $number;

    /**
     * @ORM\Column(name="emission_date", type="datebr", nullable=true)
     * @var date
     */
    protected $emissionDate;

    /**
     * @ORM\Column(name="expiration_date", type="datebr", nullable=true)
     * @var date
     */
    protected $expirationDate;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=false)
     * @var float
     */
    protected $value;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $parcels;

    /**
     * @ORM\Column(name="current_parcel", type="string", nullable=true)
     * @var string
     */
    protected $currentParcel;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $barcode;

    /**
     * @ORM\Column(name="auto_launch", type="boolean", nullable=false)
     * @var bool
     */
    protected $autoLaunch;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $fine;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $interest;

    /**
     * @ORM\Column(name="interest_interval", type="integer", nullable=true)
     * @var int
     */
    protected $interestInterval;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $notes;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var date
     */
    protected $datetime;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @var bool
     */
    protected $done;

    /**
     * @ORM\Column(name="done_date", type="datetime", nullable=true)
     * @var date
     */
    protected $doneDate;

    /**
     * @ORM\Column(name="done_value", type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $doneValue;

    /**
     * @ORM\Column(name="is_recurrent", type="boolean", nullable=false)
     * @var bool
     */
    protected $isRecurrent;

    /**
     * @ORM\Column(name="recurrence_interval", type="integer", nullable=true)
     * @var int
     */
    protected $recurrenceInterval;

    /**
     * @ORM\ManyToOne(targetEntity="DtlCurrentAccount\Entity\CurrentAccount", cascade={"persist"})
     * @var CurrentAccount
     */
    protected $currentAccount;

    /**
     * @ORM\ManyToOne(targetEntity="DtlPaymentType\Entity\PaymentType", cascade={"persist"})
     * @var PaymentType
     */
    protected $paymentType;

    /**
     * @ORM\ManyToOne(targetEntity="DtlAccountingItem\Entity\AccountingItem", cascade={"persist"})
     * @var AccountingItem
     */
    protected $accountingItem;

    /**
     * @ORM\ManyToOne(targetEntity="DtlDocumentType\Entity\DocumentType", cascade={"persist"})
     * @var DocumentType
     */
    protected $documentType;

    public function __construct() {
        $this->autoLaunch = false;
        $this->datetime = new \DateTime('now');
        $this->emissionDate = date('d/m/Y');
        $this->expirationDate = date('d/m/Y');
        $this->fine = 0;
        $this->interest = 0;
        $this->isRecurrent = false;
        $this->recurrenceInterval = 0;
        $this->value = 0;
        $this->parcels = 1;
        $this->done = 0;
        $this->doneDate = null;
        $this->doneValue = null;
    }

    public function getId() {
        return $this->id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getEmissionDate() {
        return $this->emissionDate;
    }

    public function getExpirationDate() {
        return $this->expirationDate;
    }

    public function getValue() {
        return $this->value;
    }

    public function getParcels() {
        return $this->parcels;
    }

    public function getCurrentParcel() {
        return $this->currentParcel;
    }

    public function getBarcode() {
        return $this->barcode;
    }

    public function getAutoLaunch() {
        return $this->autoLaunch;
    }

    public function getFine() {
        return $this->fine;
    }

    public function getInterest() {
        return $this->interest;
    }

    public function getInterestInterval() {
        return $this->interestInterval;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function getDatetime() {
        return $this->datetime;
    }

    public function getDone() {
        return $this->done;
    }

    public function getDoneDate() {
        return $this->doneDate;
    }

    public function getDoneValue() {
        return $this->doneValue;
    }

    public function getIsRecurrent() {
        return $this->isRecurrent;
    }

    public function getRecurrenceInterval() {
        return $this->recurrenceInterval;
    }

    public function getCurrentAccount() {
        return $this->currentAccount;
    }

    public function getPaymentType() {
        return $this->paymentType;
    }

    public function getAccountingItem() {
        return $this->accountingItem;
    }

    public function getDocumentType() {
        return $this->documentType;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setNumber($number) {
        $this->number = $number;
        return $this;
    }

    public function setEmissionDate($emissionDate) {
        $this->emissionDate = $emissionDate;
        return $this;
    }

    public function setExpirationDate($expirationDate) {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setParcels($parcels) {
        $this->parcels = $parcels;
        return $this;
    }

    public function setCurrentParcel($currentParcel) {
        $this->currentParcel = $currentParcel;
        return $this;
    }

    public function setBarcode($barcode) {
        $this->barcode = $barcode;
        return $this;
    }

    public function setAutoLaunch($autoLaunch) {
        $this->autoLaunch = $autoLaunch;
        return $this;
    }

    public function setFine($fine) {
        $this->fine = $fine;
        return $this;
    }

    public function setInterest($interest) {
        $this->interest = $interest;
        return $this;
    }

    public function setInterestInterval($interestInterval) {
        $this->interestInterval = $interestInterval;
        return $this;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
        return $this;
    }

    public function setDatetime($datetime) {
        $this->datetime = $datetime;
        return $this;
    }

    public function setDone($done) {
        $this->done = $done;
        return $this;
    }

    public function setDoneDate($doneDate) {
        $this->doneDate = $doneDate;
        return $this;
    }

    public function setDoneValue($doneValue) {
        $this->doneValue = $doneValue;
        return $this;
    }

    public function setIsRecurrent($isRecurrent) {
        $this->isRecurrent = $isRecurrent;
        return $this;
    }

    public function setRecurrenceInterval($recurrenceInterval) {
        $this->recurrenceInterval = $recurrenceInterval;
        return $this;
    }

    public function setCurrentAccount(CurrentAccount $currentAccount) {
        $this->currentAccount = $currentAccount;
        return $this;
    }

    public function setPaymentType(PaymentType $paymentType) {
        $this->paymentType = $paymentType;
        return $this;
    }

    public function setAccountingItem(AccountingItem $accountingItem) {
        $this->accountingItem = $accountingItem;
        return $this;
    }

    public function setDocumentType(DocumentType $documentType) {
        $this->documentType = $documentType;
        return $this;
    }

}
