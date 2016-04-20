<?php

namespace DtlProposal\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Product\Entity\Product;

/**
 * @ORM\Entity(repositoryClass="DtlProposal\Entity\Repository\CaixaProposal")
 * @ORM\Table(name="caixa_proposal")
 */
class CaixaProposal {

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
     * @ORM\ManyToMany(targetEntity="DtlProduct\Entity\Product", cascade={"persist"})
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
     * @param \DtlProduct\Entity\Product $product
     * @return \DtlProposal\Entity\CaixaProposal
     */
    public function addProduct(Product $product) {
        $this->products->add($product);
        return $this;
    }

    /**
     * 
     * @param ArrayCollection $products
     * @return \DtlProposal\Entity\CaixaProposal
     */
    public function setProducts($products) {
        foreach ($products as $product) {
            $this->addProduct($product);
        }
        return $this;
    }
}
