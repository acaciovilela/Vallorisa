<?php

namespace DtlEmployee\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlEmployee\Form\Fieldset\EmployeeCommission;

class EmployeeCommissionFieldsetFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sm = $serviceLocator->getServiceLocator();
        $fieldset = new EmployeeCommission();
        $fieldset->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        return $fieldset;
    }
}
