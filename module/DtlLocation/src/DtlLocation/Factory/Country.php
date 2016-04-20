<?php

namespace DtlLocation\Factory;

use DtlLocation\Controller\CountryController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Country implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new CountryController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlLocation\Entity\Country');
        return $controller;
    }
}
