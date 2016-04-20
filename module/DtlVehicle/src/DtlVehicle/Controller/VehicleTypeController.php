<?php

namespace DtlVehicle\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlVehicle\Form\VehicleType as VehicleTypeForm;
use DtlVehicle\Entity\VehicleType as VehicleTypeEntity;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;

class VehicleTypeController extends AbstractActionController {

    /**
     * @var VehicleType\Entity\VehicleTypeEntity
     */
    protected $repository;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function indexAction() {
        $this->redirect()->toRoute('dtladmin/dtlvehicle/vehicle-type/add');
    }

    public function addAction() {
        $form = new VehicleTypeForm($this->getEntityManager());
        return array(
            'form' => $form
        );
    }

    public function listAction() {
        $brand = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $vehicleType = $em->getRepository($this->getRepository())->findBy(array(
            'brand' => $brand
        ));
        return array(
            'vehicleType' => $vehicleType
        );
    }

    public function postAction() {
        $vehicle_brand_id = $this->params()->fromQuery('vehicle_brand_id');
        $vehicle_type_name = $this->params()->fromQuery('vehicle_type_name');
        $vehicleType = new VehicleTypeEntity();
        $vehicleType->setName($vehicle_type_name);
        $em = $this->getEntityManager();
        $vehicleBrand = $em->find('\DtlVehicle\Entity\VehicleBrand', $vehicle_brand_id);
        $vehicleType->setBrand($vehicleBrand);
        $em->persist($vehicleType);
        $em->flush();
        return $this->getResponse()->setContent(Json::encode(array('result' => $vehicle_type_name)));
    }

    public function deleteAction() {
        $id = $this->params()->fromQuery('vehicle_type_id');
        $em = $this->getEntityManager();
        $em->remove($em->find($this->getRepository(), $id));
        $em->flush();
        return $this->getResponse()->setContent(Json::encode(array('result' => true)));
    }
    
    public function fillAction() {
        $vehicle_brand_id = $this->params()->fromQuery('itemId');
        $em = $this->getEntityManager();
        $vehicle_brand = $em->find('DtlVehicle\Entity\VehicleBrand', $vehicle_brand_id);
        $vehicle_type = $em->getRepository('DtlVehicle\Entity\VehicleType')->findBy(array(
            'brand' => $vehicle_brand
        ));
        $options = '';
        foreach ($vehicle_type as $type) {
            $options .= '<option value="'. $type->getId() .'">' . $type->getName() . '</option>';
        }
        return $this->getResponse()->setContent(Json::encode(array('options' => $options)));
    }

    public function getRepository() {
        if (!$this->repository) {
            $this->repository = '\DtlVehicle\Entity\VehicleType';
        }
        return $this->repository;
    }

    public function setRepository(\DtlVehicle\Entity\VehicleType $repository) {
        $this->repository = $repository;
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return \Brand\Controller\BrandController
     */
    public function setEntityManager(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

}

