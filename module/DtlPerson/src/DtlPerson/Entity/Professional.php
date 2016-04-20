<?php

namespace DtlPerson\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlOffice\Entity\Office;

/**
 * @ORM\Entity
 * @ORM\Table(name="professional")
 */
class Professional {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(name="in_date", type="datebr", nullable=true)
     * @var  
     */
    protected $inDate;

    /**
     * @ORM\Column(name="company_name", type="string", nullable=true)
     * @var string 
     */
    protected $companyName;

    /**
     * @ORM\Column(name="company_cnpj", type="string", nullable=true)
     * @var string 
     */
    protected $companyCnpj;

    /**
     * @ORM\Column(name="office_name", type="string", nullable=true)
     * @var string 
     */
    protected $officeName;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $salary;

    /**
     * @ORM\Column(name="other_revenue", type="decimal", precision=11, scale=2, nullable=true)
     * @var float 
     */
    protected $otherRevenue;

    /**
     * @ORM\Column(name="notes", type="text", nullable=true)
     * @var string
     */
    protected $notes;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Contact", cascade="all")
     * @var Contact
     */
    protected $contact;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Address", cascade="all")
     * @var Address 
     */
    protected $address;

    /**
     * @ORM\ManyToOne(targetEntity="DtlOffice\Entity\Office", cascade="all")
     * @var Office
     */
    protected $office;

    public function __construct() {
        $this->salary = 0.00;
        $this->otherRevenue = 0.00;
        $this->address = new Address();
        $this->contact = new Contact();
    }

    public function getId() {
        return $this->id;
    }

    public function getInDate() {
        return $this->inDate;
    }

    public function getCompanyName() {
        return $this->companyName;
    }

    public function getCompanyCnpj() {
        return $this->companyCnpj;
    }

    public function getOfficeName() {
        return $this->officeName;
    }

    public function getSalary() {
        return $this->salary;
    }

    public function getOtherRevenue() {
        return $this->otherRevenue;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function getContact() {
        return $this->contact;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getOffice() {
        return $this->office;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setInDate($inDate) {
        $this->inDate = $inDate;
        return $this;
    }

    public function setCompanyName($companyName) {
        $this->companyName = $companyName;
        return $this;
    }

    public function setCompanyCnpj($companyCnpj) {
        $this->companyCnpj = $companyCnpj;
        return $this;
    }

    public function setOfficeName($officeName) {
        $this->officeName = $officeName;
        return $this;
    }

    public function setSalary($salary) {
        $this->salary = $salary;
        return $this;
    }

    public function setOtherRevenue($otherRevenue) {
        $this->otherRevenue = $otherRevenue;
        return $this;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
        return $this;
    }

    public function setContact(Contact $contact) {
        $this->contact = $contact;
        return $this;
    }

    public function setAddress(Address $address) {
        $this->address = $address;
        return $this;
    }

    public function setOffice(Office $office) {
        $this->office = $office;
        return $this;
    }

}
