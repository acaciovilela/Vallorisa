<?php

namespace DtlUser\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserControllerFactory implements FactoryInterface {
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sm = $serviceLocator->getServiceLocator();
        $controller = new \DtlUser\Controller\UserController();
        $controller->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        $controller->setRepository('DtlUser\Entity\User');
        return $controller;
    }
}