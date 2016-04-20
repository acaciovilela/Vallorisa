<?php

namespace DtlFinancial\Factory;

use DtlFinancial\Controller\RevenueController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RevenueFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new RevenueController();
        $controller->setEntityManager($entitymanager);
        $controller->setService($services->get('dtlfinancial_revenue_service'));
        return $controller;
    }
}
