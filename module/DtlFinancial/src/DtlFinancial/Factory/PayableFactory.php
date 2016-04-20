<?php

namespace DtlFinancial\Factory;

use DtlFinancial\Controller\PayableController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PayableFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new PayableController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlFinancial\Entity\Payable');
        return $controller;
    }
}
