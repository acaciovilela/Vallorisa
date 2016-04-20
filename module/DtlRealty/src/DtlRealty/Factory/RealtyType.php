<?php

namespace DtlRealty\Factory;

use DtlRealty\Controller\RealtyTypeController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RealtyType implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new RealtyTypeController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlRealty\Entity\RealtyType');
        return $controller;
    }
}
