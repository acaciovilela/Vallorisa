<?php

namespace DtlAccountingItem\Factory;

use DtlAccountingItem\Controller\AccountingItemController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AccountingItem implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new AccountingItemController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlAccountingItem\Entity\AccountingItem');
        return $controller;
    }
}
