<?php

namespace DtlUser\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MasterIdentityFactory implements FactoryInterface {
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sm = $serviceLocator->getServiceLocator();
        $masterIdentity = new \DtlUser\View\Helper\MasterIdentity();
        $masterIdentity->setAuth($sm->get('zfcuser_auth_service'));
        return $masterIdentity;
    }
}