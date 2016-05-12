<?php

namespace DtlProposal\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DtlProposal\Service\ProposalService as ProposalService;

class ProposalController extends AbstractActionController {

    /**
     * @var \DtlProposal\Service\Proposal
     */
    protected $proposalService;

    /**
     * @var Zend\Session\Container
     */
    protected $proposalSession;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $repository;

    public function indexAction() {
        
    }

    public function printAction() {
        
    }

    public function calculateAction() {
        $params = $this->params()->fromQuery();
        $result = $this->getProposalService()->calculate($params);
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => $result)));
    }

    /**
     * 
     * Vehicles functions
     * 
     * @return ViewModel
     */
    public function listvehiclesAction() {
        $vehicles = array();
        if (!empty($this->getProposalSession()->vehicles)) {
            $vehicles = $this->getProposalSession()->vehicles;
        }
        $view = new ViewModel(array(
            'vehicles' => $vehicles,
        ));
        $view->setTemplate('dtl-proposal/proposal/vehicle/listvehicles');
        return $view;
    }

    /**
     * 
     * @return json|boolean
     */
    public function addvehicleAction() {
        if (!$this->getProposalSession()->vehicles) {
            $this->getProposalSession()->vehicles = array();
        }
        $vehicle = $this->params()->fromQuery();
        if (empty($vehicle['brand']) ||
                empty($vehicle['type']) ||
                empty($vehicle['model']) ||
                empty($vehicle['version'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        }
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
    }

    /**
     * 
     * @return json|boolean
     */
    public function deletevehicleAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $vehicles = $this->getProposalSession()->vehicles;
        if ($item >= 0) {
            unset($vehicles[$item]);
            $this->getProposalSession()->vehicles = $vehicles;
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
    }

    /**
     * 
     * Customer Bank Accounts functions
     * 
     * @return ViewModel
     */
    public function listcustomerbankaccountAction() {
        $customerBankAccounts = array();
        if (!empty($this->getProposalSession()->customerBankAccounts)) {
            $customerBankAccounts = $this->getProposalSession()->customerBankAccounts;
        }
//        \Zend\Debug\Debug::dump($customerBankAccounts);exit;
        $view = new ViewModel(array(
            'customerBankAccounts' => $customerBankAccounts,
        ));
        $view->setTemplate('dtl-proposal/proposal/customerbankaccountlist');
        return $view;
    }

    /**
     * 
     * @return json|boolean
     */
    public function addcustomerbankaccountAction() {
        if (!$this->getProposalSession()->customerBankAccounts) {
            $this->getProposalSession()->customerBankAccounts = array();
        }
        $customerBankAccount = $this->params()->fromQuery();
        if (empty($customerBankAccount['bank']) ||
                empty($customerBankAccount['agency']) ||
                empty($customerBankAccount['account'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        }
        $this->getProposalSession()->customerBankAccounts[] = $customerBankAccount;
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
    }

    /**
     * 
     * @return json|boolean
     */
    public function deletecustomerbankaccountAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $dataId = (int) $this->params()->fromQuery('dataId');
        $customerBankAccounts = $this->getProposalSession()->customerBankAccounts;
        if ($item >= 0) {
            unset($customerBankAccounts[$item]);
            $this->getProposalSession()->customerBankAccounts = $customerBankAccounts;
            if (!empty($dataId)) {
                $em = $this->getEntityManager();
                $bankAccount = $em->find('DtlBankAccount\Entity\BankAccount', $dataId);
                $em->remove($bankAccount);
                $em->flush();
            }
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

    /**
     * 
     * Customer References functions
     * 
     * @return ViewModel
     */
    public function listcustomerreferenceAction() {
        $customerReferences = array();
        if (!empty($this->getProposalSession()->customerReferences)) {
            $customerReferences = $this->getProposalSession()->customerReferences;
        }
        $view = new ViewModel(array(
            'customerReferences' => $customerReferences,
        ));
        $view->setTemplate('dtl-proposal/proposal/customerreferencelist');
        return $view;
    }

    /**
     * 
     * @return json|boolean
     */
    public function addcustomerreferenceAction() {
        if (!$this->getProposalSession()->customerReferences) {
            $this->getProposalSession()->customerReferences = array();
        }
        $customerReference = $this->params()->fromQuery();
        if (empty($customerReference['name']) ||
                empty($customerReference['phone'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        }
        $filter = new \Zend\Filter\Digits();
        $customerReference['phone'] = $filter->filter($customerReference['phone']);
        $this->getProposalSession()->customerReferences[] = $customerReference;
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
    }

    /**
     * 
     * @return json|boolean
     */
    public function deletecustomerreferenceAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $dataId = (int) $this->params()->fromQuery('dataId');
        $customerReferences = $this->getProposalSession()->customerReferences;
        if ($item >= 0) {
            unset($customerReferences[$item]);
            $this->getProposalSession()->customerReferences = $customerReferences;
            if (!empty($dataId)) {
                $em = $this->getEntityManager();
                $reference = $em->find('DtlReference\Entity\Reference', $dataId);
                $em->remove($reference);
                $em->flush();
            }
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

    /**
     * 
     * Customer Patrimony functions
     * 
     * @return ViewModel
     */
    public function listcustomerpatrimonyAction() {
        $customerPatrimonies = array();
        if (!empty($this->getProposalSession()->customerPatrimonies)) {
            $customerPatrimonies = $this->getProposalSession()->customerPatrimonies;
        }
        $view = new ViewModel(array(
            'customerPatrimonies' => $customerPatrimonies,
        ));
        $view->setTemplate('dtl-proposal/proposal/customerpatrimonylist');
        return $view;
    }

    /**
     * 
     * @return json|boolean
     */
    public function addcustomerpatrimonyAction() {
        if (!$this->getProposalSession()->customerPatrimonies) {
            $this->getProposalSession()->customerPatrimonies = array();
        }
        $customerPatrimony = $this->params()->fromQuery();
        if (empty($customerPatrimony['name']) ||
                empty($customerPatrimony['value'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        }
        $filter = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));
        $customerPatrimony['value'] = $filter->filter($customerPatrimony['value']);
        $this->getProposalSession()->customerPatrimonies[] = $customerPatrimony;
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
    }

    /**
     * 
     * @return json|boolean
     */
    public function deletecustomerpatrimonyAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $dataId = (int) $this->params()->fromQuery('dataId');
        $customerPatrimonies = $this->getProposalSession()->customerPatrimonies;
        if ($item >= 0) {
            unset($customerPatrimonies[$item]);
            $this->getProposalSession()->customerPatrimonies = $customerPatrimonies;
            if (!empty($dataId)) {
                $em = $this->getEntityManager();
                $patrimony = $em->find('DtlPatrimony\Entity\Patrimony', $dataId);
                $em->remove($patrimony);
                $em->flush();
            }
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

    /**
     * 
     * Customer Vehicles functions
     * 
     * @return ViewModel
     */
    public function listcustomervehicleAction() {
        $customerVehicle = array();
        if (!empty($this->getProposalSession()->customerVehicles)) {
            $customerVehicle = $this->getProposalSession()->customerVehicles;
        }
        $view = new ViewModel(array(
            'customerVehicles' => $customerVehicle,
        ));
        $view->setTemplate('dtl-proposal/proposal/customervehiclelist');
        return $view;
    }

    /**
     * 
     * @return json|boolean
     */
    public function addcustomervehicleAction() {
        if (!$this->getProposalSession()->customerVehicles) {
            $this->getProposalSession()->customerVehicles = array();
        }
        $customerVehicle = $this->params()->fromQuery();
        if (empty($customerVehicle['brand']) ||
                empty($customerVehicle['type']) ||
                empty($customerVehicle['model']) ||
                empty($customerVehicle['version'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        }
        $em = $this->getEntityManager();
        $currency = new \Zend\I18n\Filter\NumberFormat(array("locale" => "pt_BR"));
        $vehicleBrand = $em->find('DtlVehicle\Entity\VehicleBrand', $customerVehicle['brand']);
        $vehicleType = $em->find('DtlVehicle\Entity\VehicleType', $customerVehicle['type']);
        $vehicleModel = $em->find('DtlVehicle\Entity\VehicleModel', $customerVehicle['model']);
        $vehicleVersion = $em->find('DtlVehicle\Entity\VehicleVersion', $customerVehicle['version']);
        $customerVehicle['brandName'] = $vehicleBrand->getVehicleBrandName();
        $customerVehicle['brandName'] = $vehicleType->getVehicleTypeName();
        $customerVehicle['modelName'] = $vehicleModel->getVehicleModelName();
        $customerVehicle['versionName'] = $vehicleVersion->getVehicleVersionName();
        $customerVehicle['value'] = $currency->filter($customerVehicle['value']);
        $this->getProposalSession()->customerVehicles[] = $customerVehicle;
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
    }

    /**
     * 
     * @return json|boolean
     */
    public function deletecustomervehicleAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $dataId = (int) $this->params()->fromQuery('dataId');
        $customerVehicles = $this->getProposalSession()->customerVehicles;
        if ($item >= 0) {
            unset($customerVehicles[$item]);
            $this->getProposalSession()->customerVehicles = $customerVehicles;
            if (!empty($dataId)) {
                $em = $this->getEntityManager();
                $vehicle = $em->find('DtlVehicle\Entity\Vehicle', $dataId);
                $$em->remove($vehicle);
                $em->flush();
            }
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function setRepository($repository) {
        $this->repository = $repository;
        return $this;
    }

    public function getProposalSession() {
        return $this->proposalSession;
    }

    public function setProposalSession($proposalSession) {
        $this->proposalSession = $proposalSession;
        return $this;
    }

    public function getProposalService() {
        return $this->proposalService;
    }

    public function setProposalService(ProposalService $proposalService) {
        $this->proposalService = $proposalService;
        return $this;
    }

}
