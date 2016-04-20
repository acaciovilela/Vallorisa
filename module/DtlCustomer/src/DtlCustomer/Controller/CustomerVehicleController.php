<?php

namespace DtlCustomer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlCustomer\Form\CustomerVehicle as CustomerVehicleForm;
use DtlVehicle\Entity\Vehicle as VehicleEntity;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;

class CustomerVehicleController extends AbstractActionController {

    /**
     * @var DtlCustomer\Entity\CustomerVehicleEntity
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
        $form = new CustomerVehicleForm($this->getEntityManager(), $id);
        return array(
            'form' => $form,
            'customerId' => $id,
        );
    }

    public function listAction() {
        $customer_id = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $customer = $em->find('DtlCustomer\Entity\Customer', $customer_id);
        return array(
            'customerId' => $customer_id,
            'customerVehicle' => $customer->getVehicles(),
        );
    }

    public function postAction() {
        $em = $this->getEntityManager();
        $customerId = $this->params()->fromQuery('customerId');
        $currencyFilter = new \Zend\I18n\Filter\NumberFormat(array("locale" => "pt_BR"));
        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);
        
        $data = $this->params()->fromQuery();
        $vehicleData['brand'] = $em->find('DtlVehicle\Entity\VehicleBrand', $data['vehicleBrandId']);
        $vehicleData['type'] = $em->find('DtlVehicle\Entity\VehicleType', $data['vehicleTypeId']);
        $vehicleData['model'] = $em->find('DtlVehicle\Entity\VehicleModel', $data['vehicleModelId']);
        $vehicleData['version'] = $em->find('DtlVehicle\Entity\VehicleVersion', $data['vehicleVersionId']);
        $vehicleData['year'] = $data['vehicleYear'];
        $vehicleData['yearModel'] = $data['vehicleYearModel'];
        $vehicleData['plate'] = $data['vehiclePlate'];
        $vehicleData['color'] = $data['vehicleColor'];
        $vehicleData['value'] = $currencyFilter->filter($data['vehicleValue']);
        
        $vehicle = new VehicleEntity();
        $hydrator->hydrate($vehicleData, $vehicle);
        
        $customer = $em->find('DtlCustomer\Entity\Customer', $customerId);
        $customer->addVehicle($vehicle);
//        \Zend\Debug\Debug::dump(count($customer->getVehicles()));exit;
        
        $em->persist($customer);
        $em->flush();
        return $this->getResponse()->setContent(Json::encode(array('result' => true)));
    }

    public function deleteAction() {
        $em = $this->getEntityManager();
        $id = $this->params()->fromQuery('vehicleId', 0);
        $vehicle = $em->find('DtlVehicle\Entity\Vehicle', $id);
        $em->remove($vehicle);
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
