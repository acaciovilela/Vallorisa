<?php

namespace DtlProposal\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProposalController extends AbstractActionController {

    /**
     * @var Zend\Session\Container
     */
    protected $proposalSession = null;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager = null;

    /**
     * @var string
     */
    protected $repository = null;

    public function indexAction() {
        
    }

    public function printAction() {
        
    }

    public function calculateAction() {
        
        $params = $this->params()->fromQuery();

        $currencyFilter = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));

        
        $parcelAmount = $params['parcelAmount'];
        $proposalValue = $currencyFilter->filter($params['proposalValue']);

        if (array_key_exists('proposalTotalValue', $params)) {
            $totalValue = $currencyFilter->filter($params['proposalTotalValue']);
            $inValue = $totalValue - $proposalValue;
        }

        $parcelValue = $proposalValue / $parcelAmount;

        $date = new \DateTime('now');
        $timestamp = $date->getTimestamp();
        $newDate = $date->setDate(date('Y', $timestamp), date('m', $timestamp) + ($parcelAmount + 1), date('d', $timestamp));
        $endDate = date('d/m/Y', $newDate->getTimestamp());

        $sDate = new \DateTime('now');
        $sTamp = $sDate->getTimestamp();
        $nDate = $sDate->setDate(date('Y', $sTamp), date('m', $sTamp) + 1, date('d', $sTamp));
        $startDate = date('d/m/Y', $nDate->getTimestamp());

        $result = array(
            'parcelValue' => $this->convertToCurrency($parcelValue),
            'startDate' => $startDate,
            'endDate' => $endDate,
        );

        if (!empty($inValue)) {
            $result['inValue'] = $this->convertToCurrency($inValue);
        }
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => $result)));
    }

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

    public function addvehicleAction() {
        if (!$this->getProposalSession()->vehicles) {
            $this->getProposalSession()->vehicles = array();
        }
        $vehicle = $this->params()->fromQuery();
        if (empty($vehicle['vehicleBrandId']) ||
                empty($vehicle['vehicleTypeId']) ||
                empty($vehicle['vehicleModelId']) ||
                empty($vehicle['vehicleVersionId'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        }
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
    }

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

    public function listcustomerbankaccountAction() {
        $customerBankAccounts = array();
        if (!empty($this->getProposalSession()->customerBankAccounts)) {
            $customerBankAccounts = $this->getProposalSession()->customerBankAccounts;
        }
        $view = new ViewModel(array(
            'customerBankAccounts' => $customerBankAccounts,
        ));
        $view->setTemplate('dtl-proposal/proposal/customerbankaccountlist');
        return $view;
    }

    public function addcustomerbankaccountAction() {
        if (!$this->getProposalSession()->customerBankAccounts) {
            $this->getProposalSession()->customerBankAccounts = array();
        }
        $customerBankAccount = $this->params()->fromQuery();
        if (empty($customerBankAccount['bank']) ||
                empty($customerBankAccount['bankAccountAgency']) ||
                empty($customerBankAccount['bankAccountAccount'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        }
        $this->getProposalSession()->customerBankAccounts[] = $customerBankAccount;
        \Zend\Debug\Debug::dump($customerBankAccount);exit;
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
    }

    public function deletecustomerbankaccountAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $dataId = (int) $this->params()->fromQuery('dataId');
        $customerBankAccounts = $this->getProposalSession()->customerBankAccounts;
        if ($item >= 0) {
            unset($customerBankAccounts[$item]);
            $this->getProposalSession()->customerBankAccounts = $customerBankAccounts;
            if (!empty($dataId)) {
                $em = $this->getEntityManager();
                $bankAccount = $em->find('BankAccount\Entity\BankAccount', $dataId);
                $em->remove($bankAccount);
                $em->flush();
            }
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

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

    public function addcustomerreferenceAction() {
        if (!$this->getProposalSession()->customerReferences) {
            $this->getProposalSession()->customerReferences = array();
        }
        $customerReference = $this->params()->fromQuery();
        if (empty($customerReference['referenceName']) ||
                empty($customerReference['referencePhone'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        }
        $filter = new \Zend\Filter\Digits();
        $customerReference['referencePhone'] = $filter->filter($customerReference['referencePhone']);
        $this->getProposalSession()->customerReferences[] = $customerReference;
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
    }

    public function deletecustomerreferenceAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $dataId = (int) $this->params()->fromQuery('dataId');
        $customerReferences = $this->getProposalSession()->customerReferences;
        if ($item >= 0) {
            unset($customerReferences[$item]);
            $this->getProposalSession()->customerReferences = $customerReferences;
            if (!empty($dataId)) {
                $em = $this->getEntityManager();
                $reference = $em->find('Reference\Entity\Reference', $dataId);
                $em->remove($reference);
                $em->flush();
            }
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

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

    public function addcustomerpatrimonyAction() {
        if (!$this->getProposalSession()->customerPatrimonies) {
            $this->getProposalSession()->customerPatrimonies = array();
        }
        $customerPatrimony = $this->params()->fromQuery();
        if (empty($customerPatrimony['patrimonyName']) ||
                empty($customerPatrimony['patrimonyValue'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        }
        $filter = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));
        $customerPatrimony['patrimonyValue'] = $filter->filter($customerPatrimony['patrimonyValue']);
        $this->getProposalSession()->customerPatrimonies[] = $customerPatrimony;
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
    }

    public function deletecustomerpatrimonyAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $dataId = (int) $this->params()->fromQuery('dataId');
        $customerPatrimonies = $this->getProposalSession()->customerPatrimonies;
        if ($item >= 0) {
            unset($customerPatrimonies[$item]);
            $this->getProposalSession()->customerPatrimonies = $customerPatrimonies;
            if (!empty($dataId)) {
                $em = $this->getEntityManager();
                $patrimony = $em->find('Patrimony\Entity\Patrimony', $dataId);
                $em->remove($patrimony);
                $em->flush();
            }
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

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

    public function addcustomervehicleAction() {
        if (!$this->getProposalSession()->customerVehicles) {
            $this->getProposalSession()->customerVehicles = array();
        }
        $customerVehicle = $this->params()->fromQuery();
        if (empty($customerVehicle['vehicleBrandId']) ||
                empty($customerVehicle['vehicleTypeId']) ||
                empty($customerVehicle['vehicleModelId']) ||
                empty($customerVehicle['vehicleVersionId'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        }
        $em = $this->getEntityManager();
        $currency = new \Zend\I18n\Filter\NumberFormat(array("locale" => "pt_BR"));
        $vehicleBrand = $em->find('DtlVehicle\Entity\VehicleBrand', $customerVehicle['vehicleBrandId']);
        $vehicleType = $em->find('DtlVehicle\Entity\VehicleType', $customerVehicle['vehicleTypeId']);
        $vehicleModel = $em->find('DtlVehicle\Entity\VehicleModel', $customerVehicle['vehicleModelId']);
        $vehicleVersion = $em->find('DtlVehicle\Entity\VehicleVersion', $customerVehicle['vehicleVersionId']);
        $customerVehicle['vehicleBrandName'] = $vehicleBrand->getVehicleBrandName();
        $customerVehicle['vehicleTypeName'] = $vehicleType->getVehicleTypeName();
        $customerVehicle['vehicleModelName'] = $vehicleModel->getVehicleModelName();
        $customerVehicle['vehicleVersionName'] = $vehicleVersion->getVehicleVersionName();
        $customerVehicle['vehicleValue'] = $currency->filter($customerVehicle['vehicleValue']);
        $this->getProposalSession()->customerVehicles[] = $customerVehicle;
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
    }

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

    public function printHistoryAction() {

        $id = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();
        $proposal = $em->find('DtlProposal\Entity\Proposal', $id);

        $this->layout()->setTemplate('layout/blank');
        return array('proposal' => $proposal);
    }
    
    public function uploadAction() {
        $id = $this->params()->fromQuery('id');
        return array(
            'id' => $id
        );
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

}
