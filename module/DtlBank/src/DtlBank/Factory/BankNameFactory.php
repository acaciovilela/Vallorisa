<?php

namespace DtlBank\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BankNameFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $sm       = $controllers->getServiceLocator();
        $entitymanager  = $sm->get('doctrine.entitymanager.orm_default');
        $viewHelper     = new \DtlBank\View\Helper\BankName();
        $viewHelper->setEntityManager($entitymanager);
        return $viewHelper;
    }
}
