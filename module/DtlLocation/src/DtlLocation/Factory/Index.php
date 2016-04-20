<?php

namespace DtlLocation\Factory;

use DtlLocation\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Index implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $controller     = new IndexController();
        return $controller;
    }
}
