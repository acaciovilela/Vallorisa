<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DtlProposal\Entity;

use Doctrine\ORM\Mapping as ORM;
use DtlProduct\Entity\Product;

/**
 * @ORM\Entity
 * @ORM\Table(name="caixa_proposal_products")
 */
class CaixaProposalProducts {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="DtlProduct\Entity\Product", cascade={"persist"})
     * @var Product
     */
    protected $product;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function getProduct() {
        return $this->product;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setProduct(Product $product) {
        $this->product = $product;
        return $this;
    }

}
