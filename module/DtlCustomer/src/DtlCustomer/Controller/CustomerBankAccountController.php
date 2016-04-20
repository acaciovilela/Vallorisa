<?php

namespace DtlCustomer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlCustomer\Form\CustomerBankAccount as CustomerBankAccountForm;
use DtlBankAccount\Entity\BankAccount;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;

class CustomerBankAccountController extends AbstractActionController {

    /**
     * @var CustomerBankAccount\Entity\CustomerBankAccount
     */
    protected $repository;

    /**
     * @
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function indexAction() {
        $this->redirect()->toRoute('dtladmin/dtlcustomer');
    }

    public function addAction() {
        $id = $this->params()->fromRoute('id');
        $form = new CustomerBankAccountForm($this->getEntityManager(), $id);
        return array(
            'form' => $form,
            'customerId' => $id,
        );
    }

    public function listAction() {
        $id = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $customer = $em->find('DtlCustomer\Entity\Customer', $id);
        return array(
            'customerId' => $id,
            'customerBankAccount' => $customer->getAccounts(),
        );
    }

    public function postAction() {
        $em = $this->getEntityManager();
        $filter = new \DtlBase\Filter\Date();
        $customer_id = $this->params()->fromQuery('customer_id');
        $bank_account_type = $this->params()->fromQuery('bank_account_type');
        $bank_account_agency = $this->params()->fromQuery('bank_account_agency');
        $bank_account_account = $this->params()->fromQuery('bank_account_account');
        $bank_account_since = $this->params()->fromQuery('bank_account_since');
        $bank = $em->find('DtlBank\Entity\Bank', $this->params()->fromQuery('bank'));
        $bankAccount = new BankAccount();
        $bankAccount->setType($bank_account_type);
        $bankAccount->setBank($bank);
        $bankAccount->setAgency($bank_account_agency);
        $bankAccount->setAccount($bank_account_account);
        $bankAccount->setSince($filter->filter($bank_account_since));
        
        if (!$bank) {
            return $this->getResponse()->setContent(Json::encode(array('result' => false)));
        }
        
        $bankEntity = $em->find('DtlBank\Entity\Bank', $bank);
        $bankAccount->setBank($bankEntity);
        
        $customer = $em->find('DtlCustomer\Entity\Customer', $customer_id);
        $customer->addAccount($bankAccount);
        
        $em->persist($customer);
        $em->flush();
        return $this->getResponse()->setContent(Json::encode(array('result' => true)));
    }

    public function deleteAction() {
        $em = $this->getEntityManager();
        $id = $this->params()->fromQuery('bank_account_id', 0);
        $em->remove($em->find('DtlBankAccount\Entity\BankAccount', $id));
        $em->flush();
        return $this->getResponse()->setContent(Json::encode(array('result' => true)));
    }

    /**
     * @return the $entityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * @param field_type $entityManager
     */
    public function setEntityManager(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @return the $repository
     */
    public function getRepository() {
        return $this->repository;
    }

    /**
     * @param field_type $repository
     */
    public function setRepository($repository) {
        $this->repository = $repository;
    }

}
