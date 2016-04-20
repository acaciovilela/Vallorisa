<?php

namespace DtlFile\Factory;

use DtlFile\Controller\FileController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FileFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new FileController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlFile\Entity\File');
        return $controller;
    }
}
