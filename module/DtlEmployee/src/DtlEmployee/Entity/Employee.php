<?php

namespace DtlEmployee\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlPerson\Entity\Person;
use DtlUser\Entity\User;
use DtlSupplier\Entity\Supplier;
use DtlEmployeeStatus\Entity\EmployeeStatus;
use DtlCompany\Entity\Company;
use DtlOffice\Entity\Office;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="DtlEmployee\Entity\Repository\Employee")
 * @ORM\Table(name="employee")
 */
class Employee {

    /**
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="admission_date", type="datebr", nullable=true)
     * @var DateTime
     */
    protected $admissionDate;

    /**
     * @ORM\Column(name="demission_date", type="datebr", nullable=true)
     * @var DateTime
     */
    protected $demissionDate;

    /**
     * @ORM\Column(name="work_time", type="integer", nullable=true)
     * @var integer 
     */
    protected $workTime;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $ctps;

    /**
     * @ORM\Column(name="ctps_serie", type="string", nullable=true)
     * @var string 
     */
    protected $ctpsSerie;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string 
     */
    protected $pis;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string 
     */
    protected $picture;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     * @var float
     */
    protected $salary;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     * @var float 
     */
    protected $bonus;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var integer 
     */
    protected $mark;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    protected $timestamp;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @var boolean 
     */
    protected $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="DtlEmployeeStatus\Entity\EmployeeStatus", cascade={"persist"})
     * @var EmployeeStatus
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="DtlOffice\Entity\Office", cascade={"persist"})
     * @var Office 
     */
    protected $office;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Person", cascade={"all"})
     * @var Person 
     */
    protected $person;

    /**
     * @ORM\ManyToOne(targetEntity="DtlUser\Entity\User", cascade={"persist"})
     * @var User 
     */
    protected $user;

    /**
     * @ORM\OneToOne(targetEntity="DtlSupplier\Entity\Supplier", cascade={"all"})
     * @var Supplier
     */
    protected $supplier;

    /**
     * @ORM\ManyToMany(targetEntity="DtlEmployee\Entity\EmployeeCommission", cascade={"all"})
     * @var EmployeeCommission
     */
    protected $commissions;

    /**
     * @ORM\ManyToMany(targetEntity="DtlFinancial\Entity\Payable", cascade={"all"})
     * @var Payable
     */
    protected $payments;

    /**
     * @ORM\ManyToOne(targetEntity="DtlCompany\Entity\Company", cascade={"persist"})
     * @var Company
     */
    protected $company;

    public function __construct() {
        $this->isActive = true;
        $this->timestamp = new \DateTime("now");
        $this->person = new Person();
        $this->supplier = new Supplier();
        $this->salary = 0.00;
        $this->bonus = 0.00;
        $this->mark = 0;
        $this->commissions = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    /**
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @return DateTime
     */
    public function getAdmissionDate() {
        return $this->admissionDate;
    }

    /**
     * 
     * @return DateTime
     */
    public function getDemissionDate() {
        return $this->demissionDate;
    }

    /**
     * 
     * @return integer
     */
    public function getWorkTime() {
        return $this->workTime;
    }

    /**
     * 
     * @return string
     */
    public function getCtps() {
        return $this->ctps;
    }

    /**
     * 
     * @return string
     */
    public function getCtpsSerie() {
        return $this->ctpsSerie;
    }

    /**
     * 
     * @return string
     */
    public function getPis() {
        return $this->pis;
    }

    /**
     * 
     * @return string
     */
    public function getPicture() {
        return $this->picture;
    }

    /**
     * 
     * @return float
     */
    public function getSalary() {
        return $this->salary;
    }

    /**
     * 
     * @return float
     */
    public function getBonus() {
        return $this->bonus;
    }

    /**
     * 
     * @return integer
     */
    public function getMark() {
        return $this->mark;
    }

    /**
     * 
     * @return DateTime
     */
    public function getTimestamp() {
        return $this->timestamp;
    }

    /**
     * 
     * @return boolean
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * 
     * @return Company
     */
    public function getCompany() {
        return $this->company;
    }

    /**
     * 
     * @return EmployeeStatus
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * 
     * @return Office
     */
    public function getOffice() {
        return $this->office;
    }

    /**
     * 
     * @return Person
     */
    public function getPerson() {
        return $this->person;
    }

    /**
     * 
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * 
     * @return Supplier
     */
    public function getSupplier() {
        return $this->supplier;
    }

    /**
     * 
     * @param integer $id
     * @return \DtlEmployee\Entity\Employee
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     * @param DateTime $admissionDate
     * @return \DtlEmployee\Entity\Employee
     */
    public function setAdmissionDate($admissionDate) {
        $this->admissionDate = $admissionDate;
        return $this;
    }

    /**
     * 
     * @param DateTime $demissionDate
     * @return \DtlEmployee\Entity\Employee
     */
    public function setDemissionDate($demissionDate) {
        $this->demissionDate = $demissionDate;
        return $this;
    }

    /**
     * 
     * @param integer $workTime
     * @return \DtlEmployee\Entity\Employee
     */
    public function setWorkTime($workTime) {
        $this->workTime = (int) $workTime;
        return $this;
    }

    /**
     * 
     * @param string $ctps
     * @return \DtlEmployee\Entity\Employee
     */
    public function setCtps($ctps) {
        $this->ctps = $ctps;
        return $this;
    }

    /**
     * 
     * @param string $ctpsSerie
     * @return \DtlEmployee\Entity\Employee
     */
    public function setCtpsSerie($ctpsSerie) {
        $this->ctpsSerie = $ctpsSerie;
        return $this;
    }

    /**
     * 
     * @param string $pis
     * @return \DtlEmployee\Entity\Employee
     */
    public function setPis($pis) {
        $this->pis = $pis;
        return $this;
    }

    /**
     * 
     * @param string $picture
     * @return \DtlEmployee\Entity\Employee
     */
    public function setPicture($picture) {
        $this->picture = $picture;
        return $this;
    }

    /**
     * 
     * @param float $salary
     * @return \DtlEmployee\Entity\Employee
     */
    public function setSalary($salary) {
        $this->salary = $salary;
        return $this;
    }

    /**
     * 
     * @param float $bonus
     * @return \DtlEmployee\Entity\Employee
     */
    public function setBonus($bonus) {
        $this->bonus = $bonus;
        return $this;
    }

    /**
     * 
     * @param integer $mark
     * @return \DtlEmployee\Entity\Employee
     */
    public function setMark($mark) {
        $this->mark = $mark;
        return $this;
    }

    /**
     * 
     * @param DateTime $timestamp
     * @return \DtlEmployee\Entity\Employee
     */
    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * 
     * @param boolean $isActive
     * @return \DtlEmployee\Entity\Employee
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * 
     * @param Company $company
     * @return \DtlCompany\Entity\Company
     */
    public function setCompany(Company $company) {
        $this->company = $company;
        return $this;
    }

    /**
     * 
     * @param EmployeeStatus $status
     * @return \DtlEmployee\Entity\Employee
     */
    public function setStatus(EmployeeStatus $status) {
        $this->status = $status;
        return $this;
    }

    /**
     * 
     * @param \DtlEmployee\Entity\Office $office
     * @return \DtlEmployee\Entity\Employee
     */
    public function setOffice(Office $office) {
        $this->office = $office;
        return $this;
    }

    /**
     * 
     * @param Person $person
     * @return \DtlEmployee\Entity\Employee
     */
    public function setPerson(Person $person) {
        $this->person = $person;
        return $this;
    }

    /**
     * 
     * @param User $user
     * @return \DtlEmployee\Entity\Employee
     */
    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    /**
     * 
     * @param Supplier $supplier
     * @return \DtlEmployee\Entity\Employee
     */
    public function setSupplier(Supplier $supplier) {
        $this->supplier = $supplier;
        return $this;
    }

    /**
     * 
     * @return Collection
     */
    public function getCommissions() {
        return $this->commissions;
    }

    /**
     * 
     * @param Collection $commissions
     * @return \DtlEmployee\Entity\Employee
     */
    public function addCommissions(Collection $commissions) {
        foreach ($commissions as $commission) {
            $this->commissions->add($commission);
        }
        return $this;
    }

    /**
     * 
     * @param Collection $commissions
     * @return \DtlEmployee\Entity\Employee
     */
    public function removeCommissions(Collection $commissions) {
        foreach ($commissions as $commission) {
            $this->commissions->removeElement($commission);
        }
        return $this;
    }

    /**
     * 
     * @param Collection $commissions
     * @return \DtlEmployee\Entity\Employee
     */
    public function setCommissions($commissions) {
        $this->commissions = $commissions;
        return $this;
    }

    /**
     * 
     * @return Collection
     */
    public function getPayments() {
        return $this->payments;
    }

    /**
     * 
     * @param Collection $payments
     * @return \DtlEmployee\Entity\Employee
     */
    public function setPayments($payments) {
        $this->payments = $payments;
        return $this;
    }

    /**
     * 
     * @param Collection $payments
     * @return \DtlEmployee\Entity\Employee
     */
    public function addPayments(Collection $payments) {
        foreach ($payments as $payment) {
            $this->payments->add($payment);
        }
        return $this;
    }

    /**
     * 
     * @param Collection $payments
     * @return \DtlEmployee\Entity\Employee
     */
    public function removePayments(Collection $payments) {
        foreach ($payments as $payment) {
            $this->payments->removeElement($payment);
        }
        return $this;
    }

    /**
     * @return string Name
     */
    public function getName() {
        return $this->person->getName();
    }
}
