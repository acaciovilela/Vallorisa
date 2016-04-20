<?php

namespace DtlBusiness\Factory;

use DtlBusiness\Controller\BusinessController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Business implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new BusinessController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlBusiness\Entity\Business');
        return $controller;
    }
}
