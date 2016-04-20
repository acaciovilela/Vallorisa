<?php

namespace DtlFinancial\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlFinancial\View\Helper\LaunchViewHelper;

class LaunchViewHelperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sm = $serviceLocator->getServiceLocator();
        $viewHelper = new LaunchViewHelper();
        $viewHelper->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        $viewHelper->setEntity('DtlFinancial\Entity\Launch');
        return $viewHelper;
    }
}
