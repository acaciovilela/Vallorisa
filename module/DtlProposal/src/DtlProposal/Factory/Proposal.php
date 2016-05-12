<?php

namespace DtlProposal\Factory;

use DtlProposal\Controller\ProposalController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Proposal implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $controller     = new ProposalController();
        $controller->setProposalSession($services->get('proposal_session_service'));
        $controller->setProposalService($services->get('proposal_service'));
        $controller->setEntityManager($entitymanager);
        $controller->setRepository('DtlProposal\Entity\Proposal');
        return $controller;
    }
}
