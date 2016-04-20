<?php

namespace DtlVehicle\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlVehicle\Form\VehicleModel as VehicleModelForm;
use DtlVehicle\Entity\VehicleModel as VehicleModelEntity;
use Doctrine\ORM\EntityManager;
use Zend\Json\Json;

class VehicleModelController extends AbstractActionController {

    /**
     * @var VehicleModel\Entity\VehicleModelEntity
     */
    protected $repository;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function indexAction() {
        $this->redirect()->toRoute('dtladmin/dtlvehicle/vehicle-model/add');
    }

    public function addAction() {
        $form = new VehicleModelForm($this->getEntityManager());
        return array(
            'form' => $form
        );
    }
    
    public function listAction() {
        $vehicle_type_id = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $vehicle_model = $em->getRepository($this->getRepository())->findBy(array(
            'type' => $vehicle_type_id
        ));
        return array(
            'vehicleModel' => $vehicle_model
        );
    }

    public function postAction() {
        $vehicle_type_id = $this->params()->fromQuery('vehicle_type_id');
        $vehicle_model_name = $this->params()->fromQuery('vehicle_model_name');
        $vehicleModel = new VehicleModelEntity();
        $vehicleModel->setName($vehicle_model_name);
        $em = $this->getEntityManager();
        $vehicleType = $em->find('\DtlVehicle\Entity\VehicleType', $vehicle_type_id);
        $vehicleModel->setType($vehicleType);
        $em->persist($vehicleModel);
        $em->flush();
        return $this->getResponse()->setContent(Json::encode(array('result' => $vehicleModel)));
    }

    public function deleteAction() {
        $id = $this->params()->fromQuery('vehicle_model_id');
        $em = $this->getEntityManager();
        $vehicleModel = $em->find($this->getRepository(), $id);
        $em->remove($vehicleModel);
        $em->flush();
        return $this->getResponse()->setContent(Json::encode(array('result' => true)));
    }
    
    public function fillAction() {
        $vehicle_type_id = $this->params()->fromQuery('itemId');
        $em = $this->getEntityManager();
        $vehicle_type = $em->find('DtlVehicle\Entity\VehicleType', $vehicle_type_id);
        $vehicle_model = $em->getRepository('DtlVehicle\Entity\VehicleModel')->findBy(array(
            'type' => $vehicle_type
        ));
        $options = '';
        foreach ($vehicle_model as $model) {
            $options .= '<option value="'. $model->getId() .'">' . $model->getName() . '</option>';
        }
        return $this->getResponse()->setContent(Json::encode(array('options' => $options)));
    }

    public function getRepository() {
        if (!$this->repository) {
            $this->repository = '\DtlVehicle\Entity\VehicleModel';
        }
        return $this->repository;
    }

    public function setRepository(\DtlVehicle\Entity\VehicleModel $repository) {
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

