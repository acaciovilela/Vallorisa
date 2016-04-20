<?php

namespace DtlEmployee\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlEmployee\Form\Employee;

class EmployeeFormFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sm = $serviceLocator->getServiceLocator();
        $form = new Employee();
        $form->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        return $form;
    }

}
