<?php

namespace DtlProposal\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DtlVehicle\Entity\Vehicle;
use DtlShopman\Entity\Shopman;
use DtlSeller\Entity\Seller;
use DtlProduct\Entity\Product;
use DtlProposal\Entity\ProposalEntityInterface;
/**
 * @ORM\Entity(repositoryClass="DtlProposal\Entity\Repository\VehicleProposal")
 * @ORM\Table(name="vehicle_proposal")
 */
class VehicleProposal implements ProposalEntityInterface {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    protected $value;

    /**
     * @ORM\Column(name="in_value", type="decimal", precision=11, scale=2)
     */
    protected $inValue;

    /**
     * @ORM\ManyToOne(targetEntity="DtlShopman\Entity\Shopman", cascade={"persist"})
     * @var Shopman 
     */
    protected $shopman;

    /**
     * @ORM\ManyToOne(targetEntity="DtlSeller\Entity\Seller", cascade={"persist"})
     * @var Seller 
     */
    protected $seller;

    /**
     * @ORM\ManyToOne(targetEntity="DtlProduct\Entity\Product", cascade={"persist"})
     * @var Product 
     */
    protected $product;

    /**
     * @ORM\OneToOne(targetEntity="DtlProposal\Entity\Proposal", cascade={"all"})
     * @var Proposal 
     */
    protected $proposal;

    /**
     * @ORM\ManyToMany(targetEntity="DtlVehicle\Entity\Vehicle", cascade={"all"})
     * @var ArrayCollection 
     */
    protected $vehicles;

    public function __construct() {
        $this->proposal = new Proposal();
        $this->vehicles = new ArrayCollection();
        $this->inValue = 0.00;
        $this->value = 0.00;
    }

    function getId() {
        return $this->id;
    }

    function getValue() {
        return $this->value;
    }

    function getInValue() {
        return $this->inValue;
    }

    function getShopman() {
        return $this->shopman;
    }

    function getSeller() {
        return $this->seller;
    }

    function getProduct() {
        return $this->product;
    }

    function getProposal() {
        return $this->proposal;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setValue($value) {
        $this->value = (float) $value;
    }

    function setInValue($inValue) {
        $this->inValue = (float) $inValue;
    }

    function setShopman(Shopman $shopman) {
        $this->shopman = $shopman;
    }

    function setSeller(Seller $seller) {
        $this->seller = $seller;
    }

    function setProduct(Product $product) {
        $this->product = $product;
    }

    function setProposal(Proposal $proposal) {
        $this->proposal = $proposal;
    }

    public function getVehicles() {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle) {
        $this->vehicles->add($vehicle);
        return $this;
    }

    public function setVehicles($vehicles) {
        foreach ($vehicles as $vehicle) {
            $this->addVehicle($vehicle);
        }
        return $this;
    }

}
