<?php

namespace DtlSupplier\Factory;

use DtlSupplier\Controller\SupplierController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Supplier implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entityManager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new SupplierController();
        $controller->setEntityManager($entityManager);
        $controller->setRepository('DtlSupplier\Entity\Supplier');
        return $controller;
    }

}
