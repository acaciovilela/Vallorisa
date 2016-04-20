<?php

namespace DtlRealty\Factory;

use DtlRealty\Controller\RealtyController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Realty implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entitymanager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new RealtyController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlRealty\Entity\Realty');
        return $controller;
    }

}
