<?php

namespace DtlEmployee\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlEmployee\View\Helper\CheckLaunchedSalary;

class CheckLaunchedSalaryFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sm = $serviceLocator->getServiceLocator();
        $viewHelper = new CheckLaunchedSalary();
        $viewHelper->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        return $viewHelper;
    }

}
