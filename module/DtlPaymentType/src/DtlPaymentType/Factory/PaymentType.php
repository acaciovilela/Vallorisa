<?php

namespace DtlPaymentType\Factory;

use DtlPaymentType\Controller\PaymentTypeController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PaymentType implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new PaymentTypeController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlPaymentType\Entity\PaymentType');
        return $controller;
    }
}
