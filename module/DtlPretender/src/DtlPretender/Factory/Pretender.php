<?php

namespace DtlPretender\Factory;

use DtlPretender\Controller\PretenderController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Pretender implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services           = $controllers->getServiceLocator();
        $entityManager      = $services->get('doctrine.entitymanager.orm_default');
        $controller         = new PretenderController();
        $controller->setEntityManager($entityManager);
        $controller->setRepository('DtlPretender\Entity\Pretender');
        return $controller;
    }

}
