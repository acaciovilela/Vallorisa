<?php

namespace DtlProposal\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DtlEmployee\Entity\Employee;
use DtlCompany\Entity\Company;
use DtlCustomer\Entity\Customer;
use DtlBank\Entity\Bank;
use DtlUser\Entity\User;

/**
 * @ORM\Entity(repositoryClass="DtlProposal\Entity\Repository\Proposal")
 * @ORM\Table(name="proposal")
 */
class Proposal {

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
    protected $number;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     * @var float 
     */
    protected $value;

    /**
     * @ORM\Column(name="parcel_amount", type="integer")
     * @var integer 
     */
    protected $parcelAmount;

    /**
     * @ORM\Column(name="parcel_value", type="decimal", precision=11, scale=2)
     * @var float 
     */
    protected $parcelValue;

    /**
     * @ORM\Column(type="datebr")
     * @var date
     */
    protected $date;

    /**
     * @ORM\Column(name="base_date", type="datebr")
     * @var date 
     */
    protected $baseDate;

    /**
     * @ORM\Column(name="start_date", type="datebr", nullable=true)
     * @var date
     */
    protected $startDate;

    /**
     * @ORM\Column(name="end_date", type="datebr", nullable=true)
     * @var date 
     */
    protected $endDate;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $commission;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @var boolean
     */
    protected $isActive;

    /**
     * @ORM\Column(name="is_approved", type="boolean")
     * @var boolean
     */
    protected $isApproved;

    /**
     * @ORM\Column(name="is_integrated", type="boolean")
     * @var boolean
     */
    protected $isIntegrated;

    /**
     * @ORM\Column(name="is_refused", type="boolean")
     * @var boolean
     */
    protected $isRefused;

    /**
     * @ORM\Column(name="is_canceled", type="boolean")
     * @var boolean
     */
    protected $isCanceled;

    /**
     * @ORM\Column(name="is_checking", type="boolean")
     * @var boolean
     */
    protected $isChecking;

    /**
     * @ORM\Column(name="is_aborted", type="boolean")
     * @var boolean
     */
    protected $isAborted;

    /**
     * @ORM\Column(name="is_pending", type="boolean")
     * @var boolean
     */
    protected $isPending;

    /**
     * @ORM\Column(name="last_change", type="datetime")
     * @var timestamp
     */
    protected $lastChange;

    /**
     * @ORM\Column(type="datetime")
     * @var timestamp
     */
    protected $timestamp;

    /**
     * @ORM\Column(name="notes", type="text", nullable=true)
     * @var string 
     */
    protected $notes;

    /**
     * @ORM\ManyToOne(targetEntity="DtlBank\Entity\Bank", cascade={"persist"})
     * @var Bank 
     */
    protected $bank;

    /**
     * @ORM\ManyToOne(targetEntity="DtlEmployee\Entity\Employee", cascade={"persist"})
     * @var Employee
     */
    protected $employee;

    /**
     * @ORM\ManyToOne(targetEntity="DtlCustomer\Entity\Customer", cascade={"persist"})
     * @var Customer
     */
    protected $customer;

    /**
     * @ORM\ManyToOne(targetEntity="DtlCompany\Entity\Company", cascade={"persist"})
     * @var Company
     */
    protected $company;

    /**
     * @ORM\ManyToMany(targetEntity="DtlProposal\Entity\Log", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $logs;

    /**
     * @ORM\ManyToMany(targetEntity="DtlProposal\Entity\BankReport", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $reports;

    /**
     * @ORM\ManyToMany(targetEntity="DtlFile\Entity\File", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $files;

    /**
     * @ORM\ManyToOne(targetEntity="DtlUser\Entity\User", cascade={"persist"})
     * @var User
     */
    protected $user;

    public function __construct() {
        $this->customer = new Customer();
        $this->reports = new ArrayCollection();
        $this->logs = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->value = 0.00;
        $this->isActive = true;
        $this->isChecking = true;
        $this->isAborted = false;
        $this->isApproved = false;
        $this->isCanceled = false;
        $this->isIntegrated = false;
        $this->isPending = false;
        $this->isRefused = false;
        $this->timestamp = new \DateTime('now');
        $this->date = date('d/m/Y');
        $this->baseDate = date('d/m/Y');
        $this->lastChange = new \DateTime('now');
        $this->parcelAmount = 1;
        $this->parcelValue = 0.00;
        $this->commission = 0.00;
    }

    public function getId() {
        return $this->id;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getValue() {
        return $this->value;
    }

    public function getParcelAmount() {
        return $this->parcelAmount;
    }

    public function getParcelValue() {
        return $this->parcelValue;
    }

    public function getDate() {
        return $this->date;
    }

    public function getBaseDate() {
        return $this->baseDate;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function getCommission() {
        return $this->commission;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function getIsApproved() {
        return $this->isApproved;
    }

    public function getIsIntegrated() {
        return $this->isIntegrated;
    }

    public function getIsRefused() {
        return $this->isRefused;
    }

    public function getIsCanceled() {
        return $this->isCanceled;
    }

    public function getIsChecking() {
        return $this->isChecking;
    }

    public function getIsAborted() {
        return $this->isAborted;
    }

    public function getIsPending() {
        return $this->isPending;
    }

    public function getLastChange() {
        return $this->lastChange;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function getBank() {
        return $this->bank;
    }

    public function getEmployee() {
        return $this->employee;
    }

    public function getCustomer() {
        return $this->customer;
    }

    public function getCompany() {
        return $this->company;
    }

    public function getLogs() {
        return $this->logs;
    }

    public function getUser() {
        return $this->user;
    }

    public function setId($id) {
        $this->id = $id;
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

    public function setParcelAmount($parcelAmount) {
        $this->parcelAmount = $parcelAmount;
        return $this;
    }

    public function setParcelValue($parcelValue) {
        $this->parcelValue = $parcelValue;
        return $this;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function setBaseDate($baseDate) {
        $this->baseDate = $baseDate;
        return $this;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
        return $this;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
        return $this;
    }

    public function setCommission($commission) {
        $this->commission = $commission;
        return $this;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

    public function setIsApproved($isApproved) {
        $this->isApproved = $isApproved;
        return $this;
    }

    public function setIsIntegrated($isIntegrated) {
        $this->isIntegrated = $isIntegrated;
        return $this;
    }

    public function setIsRefused($isRefused) {
        $this->isRefused = $isRefused;
        return $this;
    }

    public function setIsCanceled($isCanceled) {
        $this->isCanceled = $isCanceled;
        return $this;
    }

    public function setIsChecking($isChecking) {
        $this->isChecking = $isChecking;
        return $this;
    }

    public function setIsAborted($isAborted) {
        $this->isAborted = $isAborted;
        return $this;
    }

    public function setIsPending($isPending) {
        $this->isPending = $isPending;
        return $this;
    }

    public function setLastChange($lastChange) {
        $this->lastChange = $lastChange;
        return $this;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
        return $this;
    }

    public function setBank(Bank $bank) {
        $this->bank = $bank;
        return $this;
    }

    public function setEmployee(Employee $employee) {
        $this->employee = $employee;
        return $this;
    }

    public function setCustomer(Customer $customer) {
        $this->customer = $customer;
        return $this;
    }

    public function setCompany(Company $company) {
        $this->company = $company;
        return $this;
    }

    public function setLogs(ArrayCollection $logs) {
        $this->logs = $logs;
        return $this;
    }
    
    public function addLog($log) {
        $this->logs->add($log);
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function getReports() {
        return $this->reports;
    }

    public function addReport($report) {
        $this->reports->add($report);
        return $this;
    }

    public function setReports($reports) {
        foreach ($reports as $report) {
            $this->addReport($report);
        }
        return $this;
    }

    public function getFiles() {
        return $this->files;
    }

    public function addFile($file) {
        $this->files->add($file);
        return $this;
    }

    public function removeFile($file) {
        $this->files->removeElement($file);
        return $this;
    }

    public function setFiles($files) {
        foreach ($files as $file) {
            $this->addFile($file);
        }
        return $this;
    }

}
