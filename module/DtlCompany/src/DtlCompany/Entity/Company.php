<?php

namespace DtlCompany\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlUser\Entity\User;
use DtlPerson\Entity\Address;
use DtlPerson\Entity\Contact;

/**
 * @ORM\Entity(repositoryClass="DtlCompany\Entity\Repository\Company")
 * @ORM\Table(name="company")
 */
class Company {

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
    protected $name;

    /**
     * @ORM\Column(type="string", name="fancy_name", nullable=true)
     * @var string
     */
    protected $fancyName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var cnpj
     */
    protected $cnpj;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $subscription;

    /**
     * @ORM\Column(type="string", name="representative_name", nullable=true)
     * @var string
     */
    protected $representativeName;

    /**
     * @ORM\Column(type="bigint", name="representative_phone", nullable=true)
     * @var string
     */
    protected $representativePhone;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $timestamp;

    /**
     * @ORM\Column(type="boolean", name="is_master")
     * @var boolean 
     */
    protected $isMaster;

    /**
     * @ORM\Column(type="boolean", name="is_active", nullable=false)
     * @var boolean
     */
    protected $isActive;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Address", cascade={"all"})
     * @var Address
     */
    protected $address;

    /**
     * @ORM\OneToOne(targetEntity="DtlPerson\Entity\Contact", cascade={"all"})
     * @var Contact
     */
    protected $contact;

    /**
     * @ORM\ManyToOne(targetEntity="DtlUser\Entity\User", cascade={"remove"})
     * @var User
     */
    protected $user;

    public function __construct() {
        $this->timestamp = new \DateTime("now");
        $this->isActive = true;
        $this->address = new Address();
        $this->contact = new Contact();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getFancyName() {
        return $this->fancyName;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getSubscription() {
        return $this->subscription;
    }

    public function getRepresentativeName() {
        return $this->representativeName;
    }

    public function getRepresentativePhone() {
        return $this->representativePhone;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function getIsMaster() {
        return $this->isMaster;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getContact() {
        return $this->contact;
    }

    public function getUser() {
        return $this->user;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setFancyName($fancyName) {
        $this->fancyName = $fancyName;
        return $this;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
        return $this;
    }

    public function setSubscription($subscription) {
        $this->subscription = $subscription;
        return $this;
    }

    public function setRepresentativeName($representativeName) {
        $this->representativeName = $representativeName;
        return $this;
    }

    public function setRepresentativePhone($representativePhone) {
        $this->representativePhone = $representativePhone;
        return $this;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function setIsMaster($isMaster) {
        $this->isMaster = $isMaster;
        return $this;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

    public function setAddress(Address $address) {
        $this->address = $address;
        return $this;
    }

    public function setContact(Contact $contact) {
        $this->contact = $contact;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

}
