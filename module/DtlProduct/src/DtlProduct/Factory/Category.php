<?php

namespace DtlProduct\Factory;

use DtlProduct\Controller\CategoryController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Category implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new CategoryController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlProduct\Entity\Category');
        return $controller;
    }
}
