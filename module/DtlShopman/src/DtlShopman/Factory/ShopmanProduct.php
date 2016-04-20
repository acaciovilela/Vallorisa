<?php

namespace DtlShopman\Factory;

use DtlShopman\Controller\ShopmanProductController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ShopmanProduct implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entityManager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new ShopmanProductController();
        $controller->setEntityManager($entityManager);
        $controller->setRepository('DtlShopman\Entity\ShopmanProduct');
        return $controller;
    }

}
