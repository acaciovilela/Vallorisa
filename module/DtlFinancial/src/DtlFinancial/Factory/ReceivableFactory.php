<?php

namespace DtlFinancial\Factory;

use DtlFinancial\Controller\ReceivableController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ReceivableFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entitymanager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new ReceivableController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlFinancial\Entity\Receivable');
        return $controller;
    }

}
