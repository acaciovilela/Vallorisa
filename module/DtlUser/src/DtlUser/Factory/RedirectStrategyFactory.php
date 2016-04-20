<?php

namespace DtlUser\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlUser\View\Strategy\RedirectStrategy;

class RedirectStrategyFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $authenticationService = $serviceLocator->get('zfcuser_auth_service');
        return new RedirectStrategy($authenticationService);
    }

}
