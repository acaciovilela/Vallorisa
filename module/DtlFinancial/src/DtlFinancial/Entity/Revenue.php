<?php

namespace DtlFinancial\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlUser\Entity\User;
use DtlCustomer\Entity\Customer;

/**
 * @ORM\Entity(repositoryClass="DtlFinancial\Entity\Repository\Revenue")
 * @ORM\Table(name="revenue")
 */
class Revenue {
    
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
     * @ORM\ManyToOne(targetEntity="DtlCustomer\Entity\Customer", cascade={"persist"})
     * @var Customer
     */
    protected $customer;
    
    /**
     * @ORM\ManyToOne(targetEntity="DtlUser\Entity\User", cascade={"persist"})
     * @var User
     */
    protected $user;
    
    public function getId() {
        return $this->id;
    }

    public function getLaunch() {
        return $this->launch;
    }

    public function getCustomer() {
        return $this->customer;
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

    public function setCustomer(Customer $customer) {
        $this->customer = $customer;
        return $this;
    }

    public function setUser(User $user) {
        $this->user = $user;
        return $this;
    }
}
