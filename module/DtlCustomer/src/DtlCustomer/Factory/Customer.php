<?php

namespace DtlCustomer\Factory;

use DtlCustomer\Controller\CustomerController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Customer implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entityManager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new CustomerController();
        $controller->setEntityManager($entityManager);
        $controller->setRepository('DtlCustomer\Entity\Customer');
        return $controller;
    }

}
