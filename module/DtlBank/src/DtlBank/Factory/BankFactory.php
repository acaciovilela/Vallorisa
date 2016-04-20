<?php

namespace DtlBank\Factory;

use DtlBank\Controller\BankController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BankFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new BankController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlBank\Entity\Bank');
        return $controller;
    }
}
