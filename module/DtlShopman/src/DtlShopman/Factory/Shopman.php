<?php

namespace DtlShopman\Factory;

use DtlShopman\Controller\ShopmanController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Shopman implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services = $controllers->getServiceLocator();
        $entityManager = $services->get('doctrine.entitymanager.orm_default');
        $controller = new ShopmanController();
        $controller->setEntityManager($entityManager);
        $controller->setRepository('DtlShopman\Entity\Shopman');
        return $controller;
    }

}
