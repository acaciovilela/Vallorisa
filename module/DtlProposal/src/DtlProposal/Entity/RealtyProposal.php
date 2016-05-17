<?php

namespace DtlProposal\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlRealty\Entity\Realty;
use DtlRealtor\Entity\Realtor;
use DtlProposal\Entity\Proposal;
use DtlProduct\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="DtlProposal\Entity\Repository\RealtyProposal")
 * @ORM\Table(name="realty_proposal")
 */
class RealtyProposal implements ProposalEntityInterface {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="total_value", type="decimal", precision=11, scale=2)
     * @var float
     */
    protected $totalValue;

    /**
     * @ORM\Column(name="in_value", type="decimal", precision=11, scale=2)
     * @var float
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
     * @ORM\ManyToOne(targetEntity="DtlProduct\Entity\Product", cascade={"persist"})
     * @var Product
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="DtlProposal\Entity\RealtyProposalCommission", cascade={"persist"})
     * @var RealtyProposalCommission
     */
    protected $commission;

    /**
     * @ORM\OneToOne(targetEntity="DtlProposal\Entity\Proposal", cascade={"all"})
     * @var Proposal 
     */
    protected $proposal;

    /**
     * @ORM\OneToOne(targetEntity="DtlRealty\Entity\Realty", cascade={"all"})
     * @var Realty
     */
    protected $realty;

    /**
     * @ORM\ManyToMany(targetEntity="DtlProposal\Entity\RealtyEvaluation", cascade={"all"})
     * @var Collection 
     */
    protected $evaluations;

    /**
     * @ORM\ManyToMany(targetEntity="DtlDealer\Entity\Dealer", cascade={"persist"})
     * @var Collection 
     */
    protected $dealers;

    /**
     * @ORM\ManyToMany(targetEntity="DtlCustomer\Entity\Customer", cascade={"persist"})
     * @var Collection
     */
    protected $customers;

    public function __construct() {
        $this->inValue = 0.00;
        $this->totalValue = 0.00;
        $this->proposal = new Proposal();
        $this->realty = new Realty();
        $this->fgts = false;
        $this->dealers = new ArrayCollection();
        $this->customers = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getTotalValue() {
        return $this->totalValue;
    }

    public function getInValue() {
        return $this->inValue;
    }

    public function getFgts() {
        return $this->fgts;
    }

    public function getRealtor() {
        return $this->realtor;
    }

    public function getProduct() {
        return $this->product;
    }

    public function getCommission() {
        return $this->commission;
    }

    public function getProposal() {
        return $this->proposal;
    }

    public function getRealty() {
        return $this->realty;
    }

    public function getEvaluations() {
        return $this->evaluations;
    }

    public function getDealers() {
        return $this->dealers;
    }

    public function getCustomers() {
        return $this->customers;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setTotalValue($totalValue) {
        $this->totalValue = (float) $totalValue;
        return $this;
    }

    public function setInValue($inValue) {
        $this->inValue = (float) $inValue;
        return $this;
    }

    public function setFgts($fgts) {
        $this->fgts = $fgts;
        return $this;
    }

    public function setRealtor(Realtor $realtor) {
        $this->realtor = $realtor;
        return $this;
    }

    public function setProduct(Product $product) {
        $this->product = $product;
        return $this;
    }

    public function setCommission(RealtyProposalCommission $commission) {
        $this->commission = $commission;
        return $this;
    }

    public function setProposal(Proposal $proposal) {
        $this->proposal = $proposal;
        return $this;
    }

    public function setRealty(Realty $realty) {
        $this->realty = $realty;
        return $this;
    }

    public function setEvaluations(Collection $evaluations) {
        $this->evaluations = $evaluations;
        return $this;
    }

    public function addEvaluations(Collection $evaluations) {
        foreach ($evaluations as $evaluation) {
            $this->evaluations->add($evaluation);
        }
        return $this;
    }
    
    public function removeEvaluations(Collection $evaluations) {
        foreach ($evaluations as $evaluation) {
            $this->evaluations->removeElement($evaluation);
        }
        return $this;
    }

    public function setDealers(Collection $dealers) {
        $this->dealers = $dealers;
        return $this;
    }

    public function addDealers(Collection $dealers) {
        foreach ($dealers as $dealer) {
            $this->dealers->add($dealer);
        }
        return $this;
    }
    
    public function removeDealers(Collection $dealers) {
        foreach ($dealers as $dealer) {
            $this->dealers->removeElement($dealer);
        }
        return $this;
    }

    public function setCustomers(Collection $customers) {
        $this->customers = $customers;
        return $this;
    }

    public function addCustomers(Collection $customers) {
        foreach ($customers as $customer) {
            $this->customers->add($customer);
        }
        return $this;
    }
    
    public function removeCustomers(Collection $customers) {
        foreach ($customers as $customer) {
            $this->customers->removeElement($customer);
        }
        return $this;
    }

}
