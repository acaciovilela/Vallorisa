<?php

namespace DtlVehicle\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlVehicle\Form\VehicleVersion as VehicleVersionForm;
use DtlVehicle\Entity\VehicleVersion as VehicleVersionEntity;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;

class VehicleVersionController extends AbstractActionController {

    /**
     * @var VehicleVersion\Entity\VehicleVersionEntity
     */
    protected $repository;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function indexAction() {
        $this->redirect()->toRoute('dtladmin/dtlvehicle/vehicle-version/add');
    }

    public function addAction() {
        $form = new VehicleVersionForm($this->getEntityManager());
        return array(
            'form' => $form
        );
    }
    
    public function listAction() {
        $vehicle_model_id = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $vehicle_version = $em->getRepository($this->getRepository())->findBy(array(
            'model' => $vehicle_model_id
        ));
        return array(
            'vehicleVersion' => $vehicle_version
        );
    }

    public function postAction() {
        $vehicle_model_id = $this->params()->fromQuery('vehicle_model_id');
        $vehicle_version_name = $this->params()->fromQuery('vehicle_version_name');
        $vehicleVersion = new VehicleVersionEntity();
        $vehicleVersion->setName($vehicle_version_name);
        $em = $this->getEntityManager();
        $vehicleModel = $em->find('\DtlVehicle\Entity\VehicleModel', $vehicle_model_id);
        $vehicleVersion->setModel($vehicleModel);
        $em->persist($vehicleVersion);
        $em->flush();
        return $this->getResponse()->setContent(Json::encode(array('result' => $vehicleVersion)));
    }

    public function deleteAction() {
        $id = $this->params()->fromQuery('vehicle_version_id');
        $em = $this->getEntityManager();
        $vehicleVersion = $em->find($this->getRepository(), $id);
        $em->remove($vehicleVersion);
        $em->flush();
        return $this->getResponse()->setContent(Json::encode(array('result' => true)));
    }
    
    public function fillAction() {
        $vehicle_model_id = $this->params()->fromQuery('itemId');
        $em = $this->getEntityManager();
        $vehicle_model = $em->find('DtlVehicle\Entity\VehicleModel', $vehicle_model_id);
        $vehicle_version = $em->getRepository('DtlVehicle\Entity\VehicleVersion')->findBy(array(
            'model' => $vehicle_model
        ));
        $options = '';
        foreach ($vehicle_version as $type) {
            $options .= '<option value="'. $type->getId() .'">' . $type->getName() . '</option>';
        }
        return $this->getResponse()->setContent(Json::encode(array('options' => $options)));
    }
    
    public function getRepository() {
        if (!$this->repository) {
            $this->repository = '\DtlVehicle\Entity\VehicleVersion';
        }
        return $this->repository;
    }

    public function setRepository(\DtlVehicle\Entity\VehicleVersion $repository) {
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

