<?php

namespace DtlFinancial\Service;

use DtlFinancial\Service\CreateAccountInterface;
use DtlFinancial\Entity\Account;
use DtlFinancial\Entity\Payable;

class CreatePayable implements CreateAccountInterface {
    
    protected $user;
    
    protected $supplier;
    
    protected $description = "";
    
    protected $value = 0.00;
    
    protected $entityManager;
    
    function __construct() {}

    public function create() {
        
        if (!$this->getUser()) {
            throw new \Exception('Usuário inválido.');
        }
        
        if (!$this->getSupplier()) {
            throw new \Exception('Nenhum fornecedor foi definido para esta conta.');
        }
        
        $account = new Account();
        $account->setParcels(1);
        $account->setCurrentParcel(1);
        $account->setDescription($this->getDescription());
        $account->setValue($this->getValue());
        
        $payable = new Payable();
        $payable->setUser($this->getUser())
                ->setSupplier($this->getSupplier())
                ->setAccount($account);
        
        $em = $this->getEntityManager();
        
        if (!$em) {
            throw new \Exception('EntityManager não definido.');
        }
        
        $em->persist($payable);
        
        $em->flush();
        
        return $payable;
    }
    
    public function getUser() {
        return $this->user;
    }

    public function getSupplier() {
        return $this->supplier;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getValue() {
        return $this->value;
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function setSupplier($supplier) {
        $this->supplier = $supplier;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }
}
