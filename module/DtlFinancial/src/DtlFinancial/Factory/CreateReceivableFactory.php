<?php

namespace DtlFinancial\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlFinancial\Service\CreateReceivable;

class CreateReceivableFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $service = new CreateReceivable();
        $service->setEntityManager($serviceLocator->get('doctrine.entitymanager.orm_default'));
        return $service;
    }
}
