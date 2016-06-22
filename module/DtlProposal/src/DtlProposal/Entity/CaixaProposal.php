<?php

namespace DtlProposal\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="DtlProposal\Entity\Repository\CaixaProposal")
 * @ORM\Table(name="caixa_proposal")
 */
class CaixaProposal implements ProposalEntityInterface {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="DtlProposal\Entity\Proposal", cascade={"all"})
     * @var DtlProposal\Entity\Proposal 
     */
    protected $proposal;

    /**
     * @ORM\ManyToMany(targetEntity="\DtlProposal\Entity\CaixaProposalProducts", cascade={"all"})
     * @var Collection
     */
    protected $products;

    public function __construct() {
        $this->proposal = new Proposal();
        $this->products = new ArrayCollection();
    }

    /**
     * 
     * @return integer
     */
    function getId() {
        return $this->id;
    }

    /**
     * 
     * @param integer $id
     */
    function setId($id) {
        $this->id = $id;
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
     * @return \DtlProposal\Entity\CaixaProposal
     */
    public function setProposal($proposal) {
        $this->proposal = $proposal;
        return $this;
    }

    /**
     * 
     * @return ArrayCollection
     */
    public function getProducts() {
        return $this->products;
    }

    /**
     * 
     * @param Collection $products
     * @return \DtlProposal\Entity\CaixaProposal
     */
    public function addProducts(Collection $products) {
        foreach ($products as $product) {
            $this->products->add($product);
        }
        return $this;
    }

    /**
     * 
     * @param Collection $products
     * @return \DtlProposal\Entity\CaixaProposal
     */
    public function removeProducts(Collection $products) {
        foreach ($products as $product) {
            $this->products->removeElement($product);
        }
        return $this;
    }

}
