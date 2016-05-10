<?php

namespace DtlProposal\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlRealty\Entity\Realty;
use DtlProposal\Entity\RealtyEvaluation;
use DtlRealtor\Entity\Realtor;
use DtlProposal\Entity\Proposal;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="DtlProposal\Entity\Repository\RealtyProposal")
 * @ORM\Table(name="realty_proposal")
 */
class RealtyProposal {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="total_value", type="decimal", precision=11, scale=2)
     */
    protected $totalValue;

    /**
     * @ORM\Column(name="in_value", type="decimal", precision=11, scale=2)
     */
    protected $inValue;

    /**
     * @ORM\Column(name="fgts", type="boolean")
     * @var boolean
     */
    protected $fgts;

    /**
     * @ORM\ManyToOne(targetEntity="DtlRealtor\Entity\Realtor", cascade={"persist"})
     * @var Realtor 
     */
    protected $realtor;

    /**
     * @ORM\ManyToMany(targetEntity="DtlDealer\Entity\Dealer", cascade={"all"})
     * @var ArrayCollection 
     */
    protected $dealers;

    /**
     * @ORM\ManyToOne(targetEntity="DtlProduct\Entity\Product", cascade={"persist"})
     * @var Produtc 
     */
    protected $product;

    /**
     * @ORM\OneToOne(targetEntity="DtlProposal\Entity\Proposal", cascade={"all"})
     * @var Proposal 
     */
    protected $proposal;

    /**
     * @ORM\ManyToOne(targetEntity="DtlRealty\Entity\Realty", cascade={"all"})
     * @var Realty
     */
    protected $realty;

    /**
     * @ORM\ManyToMany(targetEntity="DtlProposal\Entity\RealtyEvaluation", cascade={"all"})
     * @var ArrayCollection 
     */
    protected $evaluations;

    /**
     * @ORM\OneToOne(targetEntity="DtlProposal\Entity\RealtyProposalCommission", cascade={"persist"})
     * @var RealtyProposalCommission
     */
    protected $commission;

    /**
     * @ORM\ManyToMany(targetEntity="DtlCustomer\Entity\Customer", cascade={"all"})
     * @var ArrayCollection
     */
    protected $customers;

    public function __construct() {
        $this->proposal = new Proposal();
        $this->realty = new Realty();
        $this->evaluations = new ArrayCollection();
        $this->inValue = 0.00;
        $this->totalValue = 0.00;
        $this->fgts = false;
        $this->dealers = new ArrayCollection();
        $this->customers = new ArrayCollection();
    }
    
    function getId() {
        return $this->id;
    }

    function getTotalValue() {
        return $this->totalValue;
    }

    function getInValue() {
        return $this->inValue;
    }

    function getFgts() {
        return $this->fgts;
    }

    function getRealtor() {
        return $this->realtor;
    }

    function getCommission() {
        return $this->commission;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTotalValue($totalValue) {
        $this->totalValue = $totalValue;
    }

    function setInValue($inValue) {
        $this->inValue = $inValue;
    }

    function setFgts($fgts) {
        $this->fgts = $fgts;
    }

    function setRealtor(Realtor $realtor) {
        $this->realtor = $realtor;
    }

    function setCommission(RealtyProposalCommission $commission) {
        $this->commission = $commission;
    }

    /**
     * 
     * @return \Dealer\Entity\Dealer
     */
    public function getDealers() {
        return $this->dealers;
    }

    /**
     * @param \Dealer\Entity\Dealer
     * @return \DtlProposal\Entity\RealtyProposal
     */
    public function removeDealers(\Doctrine\Common\Collections\Collection $dealers) {
        foreach ($dealers as $dealer) {
            $this->dealers->removeElement($dealer);
        }
        return $this;
    }

    /**
     * 
     * @param \Dealer\Entity\Dealer 
     * @return \DtlProposal\Entity\RealtyProposal
     */
    public function addDealers(\Doctrine\Common\Collections\Collection $dealers) {
        foreach ($dealers as $dealer) {
            $this->dealers->add($dealer);
        }
        return $this;
    }

    /**
     * 
     * @param type $dealers
     * @return \DtlProposal\Entity\RealtyProposal
     */
    public function setDealers($dealers) {
        $this->addDealers($dealers);
        return $this;
    }

    /**
     * 
     * @return \DtlProduct\Entity\Product
     */
    public function getProduct() {
        return $this->product;
    }

    /**
     * 
     * @param \DtlProduct\Entity\Product $product
     * @return \DtlProposal\Entity\RealtyProposal
     */
    public function setProduct($product) {
        $this->product = $product;
        return $this;
    }

    /**
     * @return \DtlProposal\Entity\Proposal
     */
    public function getProposal() {
        return $this->proposal;
    }

    /**
     * 
     * @param \DtlProposal\Entity\Proposal $proposal
     * @return \DtlProposal\Entity\RealtyProposal
     */
    public function setProposal($proposal) {
        $this->proposal = $proposal;
        return $this;
    }

    /**
     * 
     * @return \Realty\Entity\Realty
     */
    public function getRealty() {
        return $this->realty;
    }

    /**
     * 
     * @param \Realty\Entity\Realty $realty
     * @return \DtlProposal\Entity\RealtyProposal
     */
    public function setRealty($realty) {
        $this->realty = $realty;
        return $this;
    }

    /**
     * 
     * @return ArrayCollection
     */
    public function getEvaluations() {
        return $this->evaluations;
    }

    /**
     * 
     * @param \DtlProposal\Entity\RealtyEvaluation $evaluation
     * @return \DtlProposal\Entity\RealtyProposal
     */
    public function addEvaluations(RealtyEvaluation $evaluation) {
        $this->evaluations->add($evaluation);
        return $this;
    }

    /**
     * 
     * @param ArrayCollection $evaluations
     * @return \DtlProposal\Entity\RealtyProposal
     */
    public function setEvaluations($evaluations) {
        foreach ($evaluations as $evaluation) {
            $this->addEvaluations($evaluation);
        }
        return $this;
    }

    /**
     * 
     * @return ArrayCollection
     */
    public function getCustomers() {
        return $this->customers;
    }

    /**
     * 
     * @param ArrayCollection $customers
     * @return \DtlProposal\Entity\RealtyProposal
     */
    public function setCustomers($customers) {
        foreach ($customers as $customer) {
            $this->addCustomers($customer);
        }
        return $this;
    }

    /**
     * @param \Customer\Entity\Customer $customer
     * @return \DtlProposal\Entity\RealtyProposal
     */
    public function removeCustomers(\Doctrine\Common\Collections\Collection $customers) {
        foreach ($customers as $customer) {
            $this->customers->removeElement($customer);
        }
        return $this;
    }

    /**
     * 
     * @param \Customer\Entity\Customer 
     * @return \DtlProposal\Entity\RealtyProposal
     */
    public function addCustomers(\Doctrine\Common\Collections\Collection $customers) {
        foreach ($customers as $customer) {
            $this->customers->add($customer);
        }
        return $this;
    }

}
