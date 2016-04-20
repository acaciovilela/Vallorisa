<?php

namespace DtlDocumentType\Factory;

use DtlDocumentType\Controller\DocumentTypeController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DocumentType implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new DocumentTypeController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlDocumentType\Entity\DocumentType');
        return $controller;
    }
}
