<?php

namespace DtlEmployee\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlEmployee\View\Helper\Employee;

class EmployeeViewHelperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sm = $serviceLocator->getServiceLocator();
        $viewHelper = new Employee();
        $viewHelper->setAuthService($sm->get('zfcuser_user_service')->getAuthService());
        $viewHelper->setEntity('DtlEmployee\Entity\Employee');
        $viewHelper->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        return $viewHelper;
    }

}
