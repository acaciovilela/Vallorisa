<?php

namespace DtlProduct\Factory;

use DtlProduct\Controller\ProductController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Product implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new ProductController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlProduct\Entity\Product');
        return $controller;
    }
}
