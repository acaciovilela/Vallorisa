<?php

namespace DtlLocation\Factory;

use DtlLocation\Controller\CityController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class City implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new CityController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlLocation\Entity\City');
        return $controller;
    }
}
