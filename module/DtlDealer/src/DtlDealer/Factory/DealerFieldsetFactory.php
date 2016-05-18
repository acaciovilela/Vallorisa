<?php

namespace DtlDealer\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlDealer\Form\Fieldset\Dealer;

class DealerFieldsetFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sm = $serviceLocator->getServiceLocator();
        $fieldset = new Dealer($sm->get('doctrine.entitymanager.orm_default'));
        return $fieldset;
    }
}
