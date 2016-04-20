<?php

namespace DtlVehicle\Factory;

use DtlVehicle\Controller\VehicleTypeController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VehicleType implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new VehicleTypeController();
        $controller->setEntityManager($entitymanager);
        return $controller;
    }
}
