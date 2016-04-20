<?php

namespace DtlCompany\Factory;

use DtlCompany\Controller\CompanyController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CompanyControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new CompanyController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlCompany\Entity\Company');
        return $controller;
    }
}
