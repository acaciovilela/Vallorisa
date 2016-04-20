<?php

namespace DtlEmployee\Factory;

use DtlEmployee\Controller\Plugin\Employee;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EmployeeControllerPluginFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $sl) {
        $sm = $sl->getServiceLocator();
        $controllerPlugin = new Employee();
        $controllerPlugin->setAuthService($sm->get('zfcuser_user_service')->getAuthService());
        $controllerPlugin->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        $controllerPlugin->setEntity('DtlEmployee\Entity\Employee');
        return $controllerPlugin;
    }
}
