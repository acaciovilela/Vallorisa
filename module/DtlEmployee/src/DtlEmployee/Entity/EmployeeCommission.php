<?php

namespace DtlEmployee\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlProduct\Entity\Product;

/**
 * @ORM\Entity
 * @ORM\Table(name="employee_commission")
 */
class EmployeeCommission {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     * @var float
     */
    protected $fixed;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2, nullable=true)
     * @var float 
     */
    protected $variant;

    /**
     * @ORM\ManyToOne(targetEntity="DtlProduct\Entity\Product", cascade={"persist"})
     * @var Product
     */
    protected $product;

    public function __construct() {
        $this->fixed = 0.00;
        $this->variant = 0.00;
    }

    /**
     * 
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @return float
     */
    public function getFixed() {
        return $this->fixed;
    }

    /**
     * 
     * @return float
     */
    public function getVariant() {
        return $this->variant;
    }

    /**
     * 
     * @return Product
     */
    public function getProduct() {
        return $this->product;
    }

    /**
     * 
     * @param integer $id
     * @return \DtlEmployee\Entity\EmployeeCommission
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     * @param float $fixed
     * @return \DtlEmployee\Entity\EmployeeCommission
     */
    public function setFixed($fixed) {
        $this->fixed = $fixed;
        return $this;
    }

    /**
     * 
     * @param float $variant
     * @return \DtlEmployee\Entity\EmployeeCommission
     */
    public function setVariant($variant) {
        $this->variant = $variant;
        return $this;
    }

    /**
     * 
     * @param Product $product
     * @return \DtlEmployee\Entity\EmployeeCommission
     */
    public function setProduct(Product $product) {
        $this->product = $product;
        return $this;
    }

}
