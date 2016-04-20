<?php

namespace DtlRealtor\Factory;

use DtlRealtor\Controller\RealtorController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Realtor implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entityManager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new RealtorController();
        $controller->setEntityManager($entityManager);
        $controller->setRepository('DtlRealtor\Entity\Realtor');
        return $controller;
    }

}
