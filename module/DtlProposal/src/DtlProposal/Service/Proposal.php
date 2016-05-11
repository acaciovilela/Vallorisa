<?php

namespace DtlProposal\Service;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Http\Request;
use DtlProposal\Entity\ProposalEntityInterface;
use DtlProposal\Entity\Loan as LoanEntity;
use DtlProposal\Entity\CaixaProposal as CaixaEntity;
use DtlProposal\Entity\VehicleProposal as VehicleEntity;
use DtlProposal\Entity\RealtyProposal as RealtyEntity;

/**
 * Proposal Service Class
 */
class Proposal implements ProposalServiceInterface {

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
    protected $payableService;
    protected $receivableService;

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
                $customerBankAccount['bank'] = ($bankAccount->getBank()) ? $bankAccount->getBank()->getId() : "0";
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

    /**
     * Save method | save all proposals
     * 
     * @param ProposalEntityInterface $entity
     */
    public function save(ProposalEntityInterface $entity) {

        $em = $this->getEntityManager();

        $customer = $entity->getProposal()->getCustomer();

        $this->addCustomerBankAccount($customer);

        if ($entity instanceof VehicleEntity) {
            $this->addCustomerReference($customer);
            $this->addCustomerPatrimony($customer);
            $this->addCustomerVehicle($customer);
        }

        /**
         * Commons routines for all proposals.
         */
        $bankReport = new \DtlProposal\Entity\BankReport();
        $bankReport->setIsActive(true);
        $bankReport->setBank($entity->getProposal()->getBank());
        $entity->getProposal()->addReport($bankReport);

        $log = new \DtlProposal\Entity\Log();
        $log->setBank($entity->getProposal()->getBank());
        $log->setMessage('ABERTA: PROPOSTA EM ANÁLISE');
        $entity->getProposal()->addLog($log);

        $em->persist($entity);

        try {
            $em->flush();
        } catch (Exception $ex) {
            throw new Exception('Não foi possível salvar a proposta.');
        }

        return true;
    }

    /**
     * 
     * @param ProposalEntityInterface $entity
     * @return boolean
     * @throws Exception
     */
    public function update(ProposalEntityInterface $entity) {

        $em = $this->getEntityManager();

        $customer = $entity->getProposal()->getCustomer();

        $this->addCustomerBankAccount($customer);

        if ($entity instanceof VehicleEntity) {
            $this->addCustomerReference($customer);
            $this->addCustomerPatrimony($customer);
            $this->addCustomerVehicle($customer);
        }

        $log = new \DtlProposal\Entity\Log();
        $log->setBank($entity->getProposal()->getBank());
        $log->setMessage('ATUALIZAÇÃO: PROPOSTA ATUALIZADA!');

        $entity->getProposal()->addLog($log);
        $em->persist($entity);

        try {
            $em->flush();
        } catch (Exception $ex) {
            throw new Exception('Não foi possível atualizar a proposta.');
        }

        return true;
    }

    /**
     * 
     * @param ProposalEntityInterface $entity
     * @param post $statusPost
     */
    public function changeStatus(ProposalEntityInterface $entity, $statusPost) {

        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->getEntityManager());

        switch ($statusPost['id']) {
            case 'APPROVED':
                $data = array(
                    'isApproved' => true,
                    'isChecking' => false,
                    'isCanceled' => false,
                    'isIntegrated' => false,
                    'isRefused' => false,
                    'isAborted' => false,
                    'isPending' => false,
                    'lastChange' => date('Y-m-d H:i:s'),
                );
                $data_log = array(
                    'timestamp' => date('Y-m-d H:i:s'),
                    'message' => 'APROVADA: ' . $statusPost['notes'],
                    'bank' => $entity->getProposal()->getBank(),
                );
                $currencyFilter = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));
                $proposalParcelAmount = $statusPost['parcelAmount'];
                $proposalParcelValue = $currencyFilter->filter($statusPost['parcelValue']);
                $proposalValue = $currencyFilter->filter($statusPost['value']);

                if (!empty($proposalParcelAmount) && !empty($proposalParcelValue) && !empty($proposalValue)) {
                    $data['parcelAmount'] = $proposalParcelAmount;
                    $data['parcelValue'] = $proposalParcelValue;
                    $data['value'] = $proposalValue;
                }
                break;
            case 'ABORTED':
                $data = array(
                    'isApproved' => false,
                    'isChecking' => false,
                    'isCanceled' => false,
                    'isIntegrated' => false,
                    'isRefused' => false,
                    'isAborted' => true,
                    'isPending' => false,
                    'lastChange' => date('Y-m-d H:i:s'),
                );
                $data_log = array(
                    'timestamp' => date('Y-m-d H:i:s'),
                    'message' => 'DESISTIDA: ' . $statusPost['notes'],
                    'bank' => $entity->getProposal()->getBank(),
                );
                break;
            case 'CHECKING':
                $data = array(
                    'isApproved' => false,
                    'isChecking' => true,
                    'isCanceled' => false,
                    'isIntegrated' => false,
                    'isRefused' => false,
                    'isAborted' => false,
                    'isPending' => false,
                    'lastChange' => date('Y-m-d H:i:s'),
                );
                $data_log = array(
                    'timestamp' => date('Y-m-d H:i:s'),
                    'message' => 'ABERTA: ' . $statusPost['notes'],
                    'bank' => $entity->getProposal()->getBank(),
                );
                break;
            case 'CHECKING_IN':
                $data = array(
                    'isApproved' => false,
                    'isChecking' => true,
                    'isCanceled' => false,
                    'isIntegrated' => false,
                    'isRefused' => false,
                    'isAborted' => false,
                    'isPending' => false,
                    'lastChange' => date('Y-m-d H:i:s'),
                );
                $data_log = array(
                    'timestamp' => date('Y-m-d H:i:s'),
                    'message' => 'ABERTA (MOVIMENTAÇÃO): ' . $statusPost['notes'],
                    'bank' => $entity->getProposal()->getBank(),
                );
                break;
            case 'CANCELED':
                $data = array(
                    'isApproved' => false,
                    'isChecking' => false,
                    'isCanceled' => true,
                    'isIntegrated' => false,
                    'isRefused' => false,
                    'isAborted' => false,
                    'isPending' => false,
                    'lastChange' => date('Y-m-d H:i:s'),
                );
                $data_log = array(
                    'timestamp' => date('Y-m-d H:i:s'),
                    'message' => 'CANCELADA: ' . $statusPost['notes'],
                    'bank' => $entity->getProposal()->getBank(),
                );
                break;
            case 'REFUSED':
                $data = array(
                    'isApproved' => false,
                    'isChecking' => false,
                    'isCanceled' => false,
                    'isIntegrated' => false,
                    'isRefused' => true,
                    'isAborted' => false,
                    'isPending' => false,
                    'lastChange' => date('Y-m-d H:i:s'),
                );
                $data_log = array(
                    'timestamp' => date('Y-m-d H:i:s'),
                    'message' => 'RECUSADA: ' . $statusPost['notes'],
                    'bank' => $entity->getProposal()->getBank(),
                );
                break;
            case 'PENDING':
                $data = array(
                    'isApproved' => false,
                    'isChecking' => false,
                    'isCanceled' => false,
                    'isIntegrated' => false,
                    'isRefused' => false,
                    'isAborted' => false,
                    'isPending' => true,
                    'lastChange' => date('Y-m-d H:i:s'),
                );
                $data_log = array(
                    'timestamp' => date('Y-m-d H:i:s'),
                    'message' => 'PENDENTE: ' . $statusPost['notes'],
                    'bank' => $entity->getProposal()->getBank(),
                );
                break;
            case 'INTEGRATED':
                $data = array(
                    'isApproved' => false,
                    'isChecking' => false,
                    'isCanceled' => false,
                    'isIntegrated' => true,
                    'isRefused' => false,
                    'isAborted' => false,
                    'isPending' => false,
                    'lastChange' => date('Y-m-d H:i:s'),
                );
                $data_log = array(
                    'timestamp' => date('Y-m-d H:i:s'),
                    'message' => 'INTEGRADA: ' . $statusPost['notes'],
                    'bank' => $entity->getProposal()->getBank(),
                );

                $proposalValue = $entity->getProposal()->getValue();
                $product = $entity->getProduct();

                if ($entity instanceof LoanEntity) {
                    $module = 'MÓDULO CONSIGNADO';
                } elseif ($entity instanceof CaixaEntity) {
                    $module = 'MÓDULO CAIXA';
                } elseif ($entity instanceof RealtyEntity) {
                    $module = 'MÓDULO IMÓVEIS';
                } else {
                    $module = 'MÓDULO VEÍCULOS';
                }

                /**
                 * Generates commissions
                 * 
                 * Company and Employee commissions
                 */
                $fixedCommission = $product->getFixedCommission();
                $variantCommission = $product->getVariantCommission();
                $commisionCalc = (($proposalValue * $variantCommission) / 100) + $fixedCommission;
                $commission = number_format($commisionCalc, 2);
                $receivable = $this->getReceivableService();
                $receivable->setUser($entity->getProposal()->getUser());
                $receivable->setCustomer($entity->getProposal()->getCustomer());
                $receivable->setDescription("COM. REF. AO {$module}, Nº {$entity->getId()}");
                $receivable->setValue($commission);
                $receivable->create();

                /**
                 * Employee Commissions
                 */
                $companyCommission = $commission;
                $employee = $entity->getProposal()->getEmployee();
                $commissions = $employee->getCommissions();
                if (count($commissions)) {
                    foreach ($commissions as $commission) {
                        if ($commission->getProduct() === $product) {
                            $empFixCom = $commission->getFixed();
                            $empVarCom = $commission->getVariant();
                            $commissionCalc = (($companyCommission * $empVarCom) / 100) + $empFixCom;
                            $employeeCommission = number_format($commissionCalc, 2);
                            $supplier = $employee->getSupplier();
                            $payable = $this->getPayableService();
                            $payable->setUser($entity->getProposal()->getUser());
                            $payable->setSupplier($supplier);
                            $payable->setDescription("COM. REF. AO {$module}, Nº {$entity->getId()}.");
                            $payable->setValue($employeeCommission);
                            $payable->create();
                        }
                    }
                }

                if ($statusPost['baseDate']) {
                    $dateFilter = new \DtlBase\Filter\Date();
                    $date = new \DateTime($dateFilter->filter($statusPost['baseDate']));
                    $timestamp = $date->getTimestamp();

                    $startDate = $date->setDate(date('Y', $timestamp), date('m', $timestamp) + 1, date('d', $timestamp));
                    $endDate = $date->setDate(date('Y', $timestamp), date('m', $timestamp) + $entity->getProposal()->getParcelAmount() + 1, date('d', $timestamp));
                    $baseDate = date('Y-m-d', $timestamp);

                    $data['baseDate'] = $baseDate;
                    $data['startDate'] = $startDate;
                    $data['endDate'] = $endDate;
                }
                break;
            default:
                break;
        }

        $hydrator->hydrate($data, $entity->getProposal());

        $log = new \DtlProposal\Entity\Log();
        $hydrator->hydrate($data_log, $log);
        $entity->getProposal()->addLog($log);

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return true;
    }

    /**
     * 
     * @param ProposalEntityInterface $entity
     * @param type $bankPost
     * @return boolean
     */
    public function changeBank(ProposalEntityInterface $entity, $bankPost) {
        
        $em = $this->getEntityManager();
        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);
        $bank = $em->find('DtlBank\Entity\Bank', $bankPost['bank']);
        $dateFilter = new \DtlBase\Filter\Date();
        
        $baseDate = new \DateTime($dateFilter->filter($entity->getProposal()->getBaseDate()));
        $timestamp = $baseDate->getTimestamp();
        $endDate = $baseDate->setDate(date('Y', $timestamp), date('m', $timestamp) + $bankPost['parcelAmount'] + 1, date('d', $timestamp));

        $currencyFilter = new \DtlBase\Filter\Currency();
        
        $dataProposal = array(
            'bank' => $bank,
            'parcelAmount' => $currencyFilter->filter($bankPost['parcelAmount']),
            'parcelValue' => $currencyFilter->filter($bankPost['parcelValue']),
            'lastExpiration' => date('Y-m-d', $endDate->getTimestamp()),
            'isChecking' => true,
            'isApproved' => false,
            'isCanceled' => false,
            'isIntegrated' => false,
            'isRefused' => false,
            'isAborted' => false,
            'lastChange' => date('Y-m-d H:i:s'),
        );

        $proposal = $entity->getProposal();
        $hydrator->hydrate($dataProposal, $proposal);

        $dataLog = array(
            'bank' => $bank,
            'timestamp' => date('Y-m-d H:i:s'),
            'message' => 'ABERTA: PROPOSTA SENDO ANALISADA PELO BANCO.'
        );
        $log = new \DtlProposal\Entity\Log();
        $hydrator->hydrate($dataLog, $log);
        $proposal->addLog($log);

        $activeBankReport = $entity->getProposal()->getReports();
        if (count($activeBankReport) > 0) {
            foreach ($activeBankReport as $bankReportData) {
                $bankReportData->setIsActive(false);
                $em->persist($bankReportData);
            }
        }

        $dataBankReport = array(
            'bank' => $bank,
            'isActive' => true
        );
        $bankReport = new \DtlProposal\Entity\BankReport();
        $hydrator->hydrate($dataBankReport, $bankReport);
        $proposal->addReport($bankReport);

        $em->persist($proposal);
        $em->persist($entity);

        $em->flush();
        
        return true;
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

    public function getPayableService() {
        return $this->payableService;
    }

    public function getReceivableService() {
        return $this->receivableService;
    }

    public function setPayableService($payableService) {
        $this->payableService = $payableService;
        return $this;
    }

    public function setReceivableService($receivableService) {
        $this->receivableService = $receivableService;
        return $this;
    }

}
