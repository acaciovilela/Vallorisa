<?php

namespace DtlProposal\Service;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * Proposal Service Class
 */
class Proposal {

    /**
     *
     * @var \DtlProposal\Service\ProposalSession
     */
    protected $proposalSession;

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * 
     */
    public function __construct() {
        
    }

    /**
     * Reset all session keys
     */
    public function resetSession() {
        $this->getProposalSession()->offsetUnset('products');
        $this->getProposalSession()->offsetUnset('realties');
        $this->getProposalSession()->offsetUnset('vehicles');
        $this->getProposalSession()->offsetUnset('customerVehicles');
        $this->getProposalSession()->offsetUnset('customerPatrimonies');
        $this->getProposalSession()->offsetUnset('customerBankAccounts');
        $this->getProposalSession()->offsetUnset('customerReferences');
        $this->getProposalSession()->products = array();
        $this->getProposalSession()->realties = array();
        $this->getProposalSession()->vehicles = array();
        $this->getProposalSession()->customerVehicles = array();
        $this->getProposalSession()->customerPatrimonies = array();
        $this->getProposalSession()->customerBankAccounts = array();
        $this->getProposalSession()->customerReferences = array();
        return $this;
    }

    /**
     * 
     * Populate proposal form if customer exists
     * 
     * @param \DtlCustomer\Entity\Customer $customer
     */
    public function populate($customer) {

        /**
         * Populate Customer Bank Accounts
         */
        $customerBankAccounts = $customer->getAccounts();
        
        if (count($customerBankAccounts) > 0) {
            $customerBankAccount = array();
            foreach ($customerBankAccounts as $bankAccount) {
                $customerBankAccount['id'] = $bankAccount->getId();
                $customerBankAccount['type'] = $bankAccount->getType();
                $customerBankAccount['bankName'] = $bankAccount->getBank();
                $customerBankAccount['agency'] = $bankAccount->getAgency();
                $customerBankAccount['account'] = $bankAccount->getAccount();
                $customerBankAccount['since'] = $bankAccount->getSince();
                $customerBankAccount['bank'] = ($bankAccount->getBank()) ? $bankAccount->getBank()->getId(): "0";
                $this->getProposalSession()->customerBankAccounts[] = $customerBankAccount;
            }
        }

        /**
         * Populate Customer References
         */
        $customerRefereces = $customer->getReferences();
        if (count($customerRefereces) > 0) {
            $customerReference = array();
            foreach ($customerRefereces as $reference) {
                $customerReference['id'] = $reference->getId();
                $customerReference['type'] = $reference->getType();
                $customerReference['name'] = $reference->getName();
                $customerReference['phone'] = $reference->getPhone();
                $this->getProposalSession()->customerReferences[] = $customerReference;
            }
        }

        /**
         * Populate Customer Patrimony
         */
        $customerPatrimonies = $customer->getPatrimonies();
        if (count($customerPatrimonies) > 0) {
            $customerPatriomny = array();
            foreach ($customerPatrimonies as $patrimony) {
                $customerPatriomny['id'] = $patrimony->getId();
                $customerPatriomny['name'] = $patrimony->getName();
                $customerPatriomny['value'] = $patrimony->getValue();
                $this->getProposalSession()->customerPatrimonies[] = $customerPatriomny;
            }
        }

        $customerVehicles = $customer->getVehicles();
        if (count($customerVehicles) > 0) {
            $customerVehicle = array();
            foreach ($customerVehicles as $vehicle) {
                $customerVehicle['vehicleId'] = $vehicle->getId();
                $customerVehicle['vehicleBrandId'] = $vehicle->getBrand()->getId();
                $customerVehicle['vehicleBrandName'] = $vehicle->getBrand()->getName();
                $customerVehicle['vehicleTypeId'] = $vehicle->getType()->getId();
                $customerVehicle['vehicleTypeName'] = $vehicle->getType()->getName();
                $customerVehicle['vehicleModelId'] = $vehicle->getModel()->getId();
                $customerVehicle['vehicleModelName'] = $vehicle->getModel()->getName();
                $customerVehicle['vehicleVersionId'] = $vehicle->getVersion()->getId();
                $customerVehicle['vehicleVersionName'] = $vehicle->getVersion()->getName();
                $customerVehicle['vehicleYear'] = $vehicle->getYear();
                $customerVehicle['vehicleYearModel'] = $vehicle->getYearModel();
                $customerVehicle['vehiclePlate'] = $vehicle->getPlate();
                $customerVehicle['vehicleColor'] = $vehicle->getColor();
                $customerVehicle['vehicleValue'] = $vehicle->getValue();
                $this->getProposalSession()->customerVehicles[] = $customerVehicle;
            }
        }
    }

    /**
     * Add Customer Bank Accounts
     */
    public function addCustomerBankAccount($customer) {
        $customerBankAccounts = $this->getProposalSession()->customerBankAccounts;
        if (count($customerBankAccounts) > 0) {
            foreach ($customerBankAccounts as $bankAccountsData) {
//                \Zend\Debug\Debug::dump($bankAccountsData);exit;
                if (!$bankAccountsData['id']) {
                    $bankAccount = new \DtlBankAccount\Entity\BankAccount();
                    $doctrineHydrator = new DoctrineHydrator($this->getEntityManager());
                    $doctrineHydrator->hydrate($bankAccountsData, $bankAccount);
                    $customer->addAccount($bankAccount);
                }
            }
        }
        return $customer;
    }

    /**
     * Add Customer Reference
     */
    public function addCustomerReference($customer) {
        $customerReferences = $this->getProposalSession()->customerReferences;
        if (count($customerReferences) > 0) {
            foreach ($customerReferences as $referenceData) {
                if (!$referenceData['id']) {
                    $reference = new \DtlReference\Entity\Reference();
                    $doctrineHydrator = new DoctrineHydrator($this->getEntityManager());
                    $doctrineHydrator->hydrate($referenceData, $reference);
                    $customer->addReference($reference);
                }
            }
        }
        return $customer;
    }

    /**
     * Add Customer Patrimony
     */
    public function addCustomerPatrimony($customer) {
        $customerPatrimonies = $this->getProposalSession()->customerPatrimonies;
        if (count($customerPatrimonies) > 0) {
            foreach ($customerPatrimonies as $patrimonyData) {
                if (!$patrimonyData['id']) {
                    $patrimony = new \DtlPatrimony\Entity\Patrimony();
                    $doctrineHydrator = new DoctrineHydrator($this->getEntityManager());
                    $doctrineHydrator->hydrate($patrimonyData, $patrimony);
                    $customer->addPatrimony($patrimony);
                }
            }
        }
        return $customer;
    }

    /**
     * Add Customer Vehicle
     */
    public function addCustomerVehicle($customer) {
        $customerVehicles = $this->getProposalSession()->customerVehicles;
        if (count($customerVehicles) > 0) {
            foreach ($customerVehicles as $vehicleData) {
                if (!$vehicleData['id']) {
                    $vehicle = new \DtlVehicle\Entity\Vehicle();
                    $doctrineHydrator = new DoctrineHydrator($this->getEntityManager());
                    $doctrineHydrator->hydrate($vehicleData, $vehicle);
                    $customer->addVehicle($vehicle);
                }
            }
        }
        return $customer;
    }

    public function addProposalVehicles($vehicleProposal) {
        $vehicles = $vehicleProposal->getVehicles();
        if (count($vehicles) > 0) {
            $proposalVehicle = array();
            foreach ($vehicles as $vehicle) {
                $proposalVehicle['id'] = $vehicle->getId();
                $proposalVehicle['brand'] = $vehicle->getBrand()->getName();
                $proposalVehicle['type'] = $vehicle->getType()->getName();
                $proposalVehicle['model'] = $vehicle->getModel()->getName();
                $proposalVehicle['version'] = $vehicle->getVersion()->getName();
                $proposalVehicle['year'] = $vehicle->getYear();
                $proposalVehicle['yearModel'] = $vehicle->getYearModel();
                $proposalVehicle['plate'] = $vehicle->getPlate();
                $proposalVehicle['value'] = $vehicle->getValue();
                $this->getProposalSession()->vehicles[] = $proposalVehicle;
            }
        }
    }

    public function addProposalProducts($caixaProposal) {
        $products = $caixaProposal->getProducts();
        if (count($products) > 0) {
            $proposalProducts = array();
            foreach ($products as $product) {
                $proposalProducts['productId'] = $product->getId();
                $proposalProducts['productName'] = $product->getName();
                $this->getProposalSession()->products[] = $proposalProducts;
            }
        }
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    public function getProposalSession() {
        return $this->proposalSession;
    }

    public function setProposalSession($proposalSession) {
        $this->proposalSession = $proposalSession;
        return $this;
    }

}
