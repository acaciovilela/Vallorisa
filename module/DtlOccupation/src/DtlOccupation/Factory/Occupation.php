<?php

namespace DtlOccupation\Factory;

use DtlOccupation\Controller\OccupationController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Occupation implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entitymanager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new OccupationController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlOccupation\Entity\Occupation');
        return $controller;
    }

}
