<?php

namespace DtlProposal\Factory;

use DtlProposal\Controller\CaixaProposalController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CaixaProposal implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new CaixaProposalController();
        $controller->setProposalSession($services->get('proposal_session_service'));
        $controller->setProposalService($services->get('proposal_service'));
        $controller->setEntityManager($entitymanager);
        $controller->setSearchQuery($services->get('proposal_search_query'));
        $controller->setRepository('DtlProposal\Entity\CaixaProposal');
        return $controller;
    }
}
