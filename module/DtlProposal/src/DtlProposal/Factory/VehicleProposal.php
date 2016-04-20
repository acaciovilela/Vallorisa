<?php

namespace DtlProposal\Factory;

use DtlProposal\Controller\VehicleProposalController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VehicleProposal implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new VehicleProposalController();
        $controller->setProposalSession($services->get('proposal_session_service'));
        $controller->setProposalService($services->get('proposal_service'));
        $controller->setEntityManager($entitymanager);
        $controller->setSearchQuery($services->get('proposal_search_query'));
        $controller->setRepository('DtlProposal\Entity\VehicleProposal');
        return $controller;
    }
}
