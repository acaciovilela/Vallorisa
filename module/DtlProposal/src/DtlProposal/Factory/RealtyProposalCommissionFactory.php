<?php

namespace DtlProposal\Factory;

use DtlProposal\Controller\RealtyProposalCommissionController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RealtyProposalCommissionFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new RealtyProposalCommissionController();
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlProposal\Entity\RealtyProposalCommission');
        return $controller;
    }
}
