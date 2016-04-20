<?php

namespace DtlVehicle\Factory;

use DtlVehicle\Controller\VehicleVersionController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VehicleVersion implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new VehicleVersionController();
        $controller->setEntityManager($entitymanager);
        return $controller;
    }
}
