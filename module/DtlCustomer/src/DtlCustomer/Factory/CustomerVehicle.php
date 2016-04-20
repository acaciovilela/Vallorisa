<?php

namespace DtlCustomer\Factory;

use DtlCustomer\Controller\CustomerVehicleController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CustomerVehicle implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entitymanager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new CustomerVehicleController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlCustomer\Entity\CustomerVehicle');
        return $controller;
    }

}
