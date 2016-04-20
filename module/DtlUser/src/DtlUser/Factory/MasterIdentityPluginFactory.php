<?php

namespace DtlUser\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MasterIdentityPluginFactory implements FactoryInterface {
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sm = $serviceLocator->getServiceLocator();
        $masterIdentity = new \DtlUser\Controller\Plugin\MasterIdentity();
        $masterIdentity->setAuth($sm->get('zfcuser_auth_service'));
        return $masterIdentity;
    }
}
