<?php

namespace DtlFinancial\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlFinancial\Service\CreatePayable;

class CreatePayableFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $service = new CreatePayable();
        $service->setEntityManager($serviceLocator->get('doctrine.entitymanager.orm_default'));
        return $service;
    }
}
