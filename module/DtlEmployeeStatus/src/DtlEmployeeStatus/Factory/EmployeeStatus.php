<?php

namespace DtlEmployeeStatus\Factory;

use DtlEmployeeStatus\Controller\EmployeeStatusController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EmployeeStatus implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entitymanager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new EmployeeStatusController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlEmployeeStatus\Entity\EmployeeStatus');
        return $controller;
    }

}
