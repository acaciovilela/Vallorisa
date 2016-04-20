<?php

namespace DtlFinancial\Factory;

use DtlFinancial\Controller\ExpenseController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExpenseFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new ExpenseController();
        $controller->setEntityManager($entitymanager);
        $controller->setService($services->get('dtlfinancial_expense_service'));
        return $controller;
    }
}
