<?php

namespace DtlFinancial\Service;

use DtlFinancial\Service\CreateAccountInterface;
use DtlFinancial\Entity\Account;
use DtlFinancial\Entity\Receivable;

class CreateReceivable implements CreateAccountInterface {
    
    protected $user;
    
    protected $customer;
    
    protected $description = "";
    
    protected $value = 0.00;
    
    protected $entityManager;
    
    function __construct() {}

    public function create() {
        
        if (!$this->getUser()) {
            throw new Exception('Não foi definido a empresa a qual pertence a conta.');
        }
        
        if (!$this->getCustomer()) {
            throw new Exception('Nenhum fornecedor foi definido para esta conta.');
        }
        
        $account = new Account();
        $account->setParcels(1);
        $account->setCurrentParcel(1);
        $account->setDescription($this->getDescription());
        $account->setValue($this->getValue());
        
        $receivable = new Receivable();
        $receivable->setUser($this->getUser()->getId())
                ->setCustomer($this->getCustomer())
                ->setAccount($account);
        
        $em = $this->getEntityManager();
        
        if (!$em) {
            throw new Exception('EntityManager não definido.');
        }
        
        $em->persist($receivable);
        
        $em->flush();
        
        return $receivable;
    }
    
    public function getUser() {
        return $this->user;
    }

    public function getCustomer() {
        return $this->customer;
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

    public function setCustomer($customer) {
        $this->customer = $customer;
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
