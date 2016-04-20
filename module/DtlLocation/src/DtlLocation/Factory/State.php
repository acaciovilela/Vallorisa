<?php

namespace DtlLocation\Factory;

use DtlLocation\Controller\StateController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class State implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new StateController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlLocation\Entity\State');
        return $controller;
    }
}
