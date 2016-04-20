<?php

namespace DtlEmployee\Factory;

use DtlEmployee\Controller\EmployeeController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EmployeeFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entityManager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new EmployeeController();
        $controller->setEntityManager($entityManager);
        $controller->setRepository('DtlEmployee\Entity\Employee');
        return $controller;
    }

}
