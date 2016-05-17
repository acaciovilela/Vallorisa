<?php

namespace DtlProposal\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlShopman\Entity\Shopman;
use DtlProposal\Entity\Proposal;
use DtlProduct\Entity\Product;
use DtlProposal\Entity\ProposalEntityInterface;

/**
 * @ORM\Entity(repositoryClass="DtlProposal\Entity\Repository\LoanProposal")
 * @ORM\Table(name="loan")
 */
class LoanProposal implements ProposalEntityInterface {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer 
     */
    protected $id;

    /**
     * @ORM\Column(name="benefit_number", type="string")
     * @var string 
     */
    protected $benefitNumber;

    /**
     * @ORM\Column(name="benefit_uf", type="string")
     * @var string
     */
    protected $benefitUf;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $margin;

    /**
     * @ORM\OneToOne(targetEntity="DtlProposal\Entity\Proposal", cascade={"all"})
     * @var Proposal 
     */
    protected $proposal;

    /**
     * @ORM\ManyToOne(targetEntity="DtlShopman\Entity\Shopman", cascade={"persist"})
     * @var Shopman
     */
    protected $shopman;

    /**
     * @ORM\ManyToOne(targetEntity="DtlProduct\Entity\Product", cascade={"persist"})
     * @var Product 
     */
    protected $product;

    public function __construct() {
        $this->margin = 0;
        $this->proposal = new Proposal();
    }

    function getId() {
        return $this->id;
    }

    function getBenefitNumber() {
        return $this->benefitNumber;
    }

    function getBenefitUf() {
        return $this->benefitUf;
    }

    function getMargin() {
        return $this->margin;
    }

    function getProposal() {
        return $this->proposal;
    }

    function getShopman() {
        return $this->shopman;
    }

    function getProduct() {
        return $this->product;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setBenefitNumber($benefitNumber) {
        $this->benefitNumber = $benefitNumber;
    }

    function setBenefitUf($benefitUf) {
        $this->benefitUf = $benefitUf;
    }

    function setMargin($margin) {
        $this->margin = (float) $margin;
    }

    function setProposal(Proposal $proposal) {
        $this->proposal = $proposal;
    }

    function setShopman(Shopman $shopman) {
        $this->shopman = $shopman;
    }

    function setProduct(Product $product) {
        $this->product = $product;
    }

}
