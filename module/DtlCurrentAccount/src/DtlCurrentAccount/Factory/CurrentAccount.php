<?php

namespace DtlCurrentAccount\Factory;

use DtlCurrentAccount\Controller\CurrentAccountController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CurrentAccount implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entitymanager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new CurrentAccountController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlCurrentAccount\Entity\CurrentAccount');
        return $controller;
    }

}
