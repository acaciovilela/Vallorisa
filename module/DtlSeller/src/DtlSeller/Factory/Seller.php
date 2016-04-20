<?php

namespace DtlSeller\Factory;

use DtlSeller\Controller\SellerController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Seller implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entityManager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new SellerController();
        $controller->setEntityManager($entityManager);
        $controller->setRepository('DtlSeller\Entity\Seller');
        return $controller;
    }

}
