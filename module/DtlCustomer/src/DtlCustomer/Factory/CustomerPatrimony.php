<?php

namespace DtlCustomer\Factory;

use DtlCustomer\Controller\CustomerPatrimonyController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CustomerPatrimony implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entitymanager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new CustomerPatrimonyController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlPatrimony\Entity\Patrimony');
        return $controller;
    }

}
