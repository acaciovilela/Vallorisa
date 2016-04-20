<?php

namespace DtlCurrency\Factory;

use DtlCurrency\Controller\CurrencyController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Currency implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entitymanager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new CurrencyController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlCurrency\Entity\Currency');
        return $controller;
    }

}
