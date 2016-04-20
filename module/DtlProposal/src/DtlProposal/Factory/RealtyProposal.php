<?php

namespace DtlProposal\Factory;

use DtlProposal\Controller\RealtyProposalController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RealtyProposal implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new RealtyProposalController();
        $controller->setProposalSession($services->get('proposal_session_service'));
        $controller->setProposalService($services->get('proposal_service'));
        $controller->setEntityManager($entitymanager);
        $controller->setSearchQuery($services->get('proposal_search_query'));
        $controller->setRepository('DtlProposal\Entity\RealtyProposal');
        return $controller;
    }
}
