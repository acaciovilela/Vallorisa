<?php

namespace DtlFinancial\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlUser\Entity\User;
use DtlSupplier\Entity\Supplier;

/**
 * @ORM\Entity(repositoryClass="DtlFinancial\Entity\Repository\Payable")
 * @ORM\Table(name="payable")
 */
class Payable {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="DtlSupplier\Entity\Supplier", cascade={"persist"})
     * @var Supplier
     */
    protected $supplier;
    
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

    public function getSupplier() {
        return $this->supplier;
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

    public function setSupplier(Supplier $supplier) {
        $this->supplier = $supplier;
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
