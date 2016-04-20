<?php

namespace DtlVehicle\Factory;

use DtlVehicle\Controller\VehicleBrandController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VehicleBrand implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new VehicleBrandController();
        $controller->setEntityManager($entitymanager);
        return $controller;
    }
}
