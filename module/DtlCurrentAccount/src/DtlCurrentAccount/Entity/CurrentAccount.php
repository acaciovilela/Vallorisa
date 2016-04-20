<?php

namespace DtlCurrentAccount\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlBank\Entity\Bank;
use DtlUser\Entity\User;
use DtlCurrency\Entity\Currency;


/**
 * @ORM\Entity
 * @ORM\Table(name="current_account")
 */
class CurrentAccount {

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
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $agency;

    /**
     * @ORM\Column(name="agency_vd", type="string", nullable=true)
     * @var string
     */
    protected $agencyVd;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $account;

    /**
     * @ORM\Column(name="account_vd", type="string", nullable=true)
     * @var string
     */
    protected $accountVd;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $manager;

    /**
     * @ORM\Column(name="manager_phone", type="string", nullable=true)
     * @var string
     */
    protected $managerPhone;

    /**
     * @ORM\Column(name="manager_email", type="string", nullable=true)
     * @var string
     */
    protected $managerEmail;

    /**
     * @ORM\Column(name="bank_website", type="string", nullable=true)
     * @var string
     */
    protected $bankWebsite;

    /**
     * @ORM\Column(name="credit_limit", type="decimal", precision=11, scale=2, nullable=true)
     * @var string
     */
    protected $creditLimit;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var string
     */
    protected $expiration;

    /**
     * @ORM\Column(name="open_date", type="date", nullable=true)
     * @var string
     */
    protected $openDate;

    /**
     * @ORM\Column(name="open_balance", type="decimal", precision=11, scale=2, nullable=true)
     * @var string
     */
    protected $openBalance;

    /**
     * @ORM\Column(name="holder_code", type="string", nullable=true)
     * @var string
     */
    protected $holderCode;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(name="is_closed", type="boolean")
     * @var string
     */
    protected $isClosed;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @var string
     */
    protected $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="DtlBank\Entity\Bank", cascade={"persist"})
     * @var Bank
     */
    protected $bank;

    /**
     * @ORM\ManyToOne(targetEntity="DtlUser\Entity\User", cascade={"persist"})
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="DtlCurrency\Entity\Currency", cascade={"persist"})
     * @var Currency
     */
    protected $currency;
    
    /**
     * @ORM\ManyToOne(targetEntity="DtlCompany\Entity\Company", cascade={"persist"})
     * @var Company
     */
    protected $company;

    public function __construct() {
        $this->limit = 0;
        $this->openBalance = 0;
        $this->isClosed = 0;
        $this->isActive = 1;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getAgency() {
        return $this->agency;
    }

    public function getAgencyVd() {
        return $this->agencyVd;
    }

    public function getAccount() {
        return $this->account;
    }

    public function getAccountVd() {
        return $this->accountVd;
    }

    public function getManager() {
        return $this->manager;
    }

    public function getManagerPhone() {
        return $this->managerPhone;
    }

    public function getManagerEmail() {
        return $this->managerEmail;
    }

    public function getBankWebsite() {
        return $this->bankWebsite;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function getExpiration() {
        return $this->expiration;
    }

    public function getOpenDate() {
        return $this->openDate;
    }

    public function getOpenBalance() {
        return $this->openBalance;
    }

    public function getHolderCode() {
        return $this->holderCode;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getIsClosed() {
        return $this->isClosed;
    }

    public function getIsActive() {
        return $this->isActive;
    }

    public function getBank() {
        return $this->bank;
    }

    public function getUser() {
        return $this->user;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setAgency($agency) {
        $this->agency = $agency;
        return $this;
    }

    public function setAgencyVd($agencyVd) {
        $this->agencyVd = $agencyVd;
        return $this;
    }

    public function setAccount($account) {
        $this->account = $account;
        return $this;
    }

    public function setAccountVd($accountVd) {
        $this->accountVd = $accountVd;
        return $this;
    }

    public function setManager($manager) {
        $this->manager = $manager;
        return $this;
    }

    public function setManagerPhone($managerPhone) {
        $this->managerPhone = $managerPhone;
        return $this;
    }

    public function setManagerEmail($managerEmail) {
        $this->managerEmail = $managerEmail;
        return $this;
    }

    public function setBankWebsite($bankWebsite) {
        $this->bankWebsite = $bankWebsite;
        return $this;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function setExpiration($expiration) {
        $this->expiration = $expiration;
        return $this;
    }

    public function setOpenDate($openDate) {
        $this->openDate = $openDate;
        return $this;
    }

    public function setOpenBalance($openBalance) {
        $this->openBalance = $openBalance;
        return $this;
    }

    public function setHolderCode($holderCode) {
        $this->holderCode = $holderCode;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setIsClosed($isClosed) {
        $this->isClosed = $isClosed;
        return $this;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }

    public function setBank(Bank $bank) {
        $this->bank = $bank;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setCurrency(Currency $currency) {
        $this->currency = $currency;
        return $this;
    }

    public function getCreditLimit() {
        return $this->creditLimit;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCreditLimit($creditLimit) {
        $this->creditLimit = $creditLimit;
        return $this;
    }

    public function setCompany(Company $company) {
        $this->company = $company;
        return $this;
    }


}
