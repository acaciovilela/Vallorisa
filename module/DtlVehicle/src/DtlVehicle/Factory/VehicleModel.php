<?php

namespace DtlVehicle\Factory;

use DtlVehicle\Controller\VehicleModelController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VehicleModel implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new VehicleModelController();
        $controller->setEntityManager($entitymanager);
        return $controller;
    }
}
