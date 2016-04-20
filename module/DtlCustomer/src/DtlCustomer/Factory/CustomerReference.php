<?php

namespace DtlCustomer\Factory;

use DtlCustomer\Controller\CustomerReferenceController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CustomerReference implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entitymanager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new CustomerReferenceController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlReference\Entity\Reference');
        return $controller;
    }

}
