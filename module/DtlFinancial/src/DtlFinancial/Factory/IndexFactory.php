<?php

namespace DtlFinancial\Factory;

use DtlFinancial\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new IndexController();
        $controller->setEntityManager($entitymanager);
        return $controller;
    }
}
