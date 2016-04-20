<?php

namespace DtlProposal\Factory;

use DtlProposal\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Index implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entitymanager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new IndexController();
        $controller->setEntityManager($entitymanager);
        return $controller;
    }

}
