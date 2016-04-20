<?php

namespace DtlFinancial\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlUser\Entity\User;
use DtlSupplier\Entity\Supplier;

/**
 * @ORM\Entity(repositoryClass="DtlFinancial\Entity\Repository\Expense")
 * @ORM\Table(name="expense")
 */
class Expense {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\OneToOne(targetEntity="DtlFinancial\Entity\Launch", cascade={"all"})
     * @var Launch
     */
    protected $launch;
    
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
    
    public function __construct() {
        $this->launch = new Launch();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getLaunch() {
        return $this->launch;
    }

    public function getSupplier() {
        return $this->supplier;
    }

    public function getUser() {
        return $this->user;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setLaunch(Launch $launch) {
        $this->launch = $launch;
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
}
