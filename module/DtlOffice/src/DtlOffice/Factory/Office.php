<?php

namespace DtlOffice\Factory;

use DtlOffice\Controller\OfficeController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Office implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new OfficeController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlOffice\Entity\Office');
        return $controller;
    }
}
