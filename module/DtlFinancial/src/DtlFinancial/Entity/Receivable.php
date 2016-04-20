<?php

namespace DtlFinancial\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlUser\Entity\User;
use DtlCustomer\Entity\Customer;

/**
 * @ORM\Entity(repositoryClass="DtlFinancial\Entity\Repository\Receivable")
 * @ORM\Table(name="receivable")
 */
class Receivable {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="DtlCustomer\Entity\Customer", cascade={"persist"})
     * @var Customer
     */
    protected $customer;

    /**
     * @ORM\ManyToOne(targetEntity="DtlUser\Entity\User", cascade={"persist"})
     * @var User
     */
    protected $user;

    /**
     * @ORM\OneToOne(targetEntity="DtlFinancial\Entity\Account", cascade={"all"})
     * @var Account
     */
    protected $account;

    public function __construct() {
        $this->account = new Account();
    }

    public function getId() {
        return $this->id;
    }

    public function getCustomer() {
        return $this->customer;
    }

    public function getUser() {
        return $this->user;
    }

    public function getAccount() {
        return $this->account;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setCustomer(Customer $customer) {
        $this->customer = $customer;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }

    public function setAccount(Account $account) {
        $this->account = $account;
        return $this;
    }

}
