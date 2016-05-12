<?php

namespace DtlProposal\Factory;

use DtlProposal\Controller\LoanController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Loan implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $services       = $controllers->getServiceLocator();
        $entitymanager  = $services->get('doctrine.entitymanager.orm_default');
        $session        = $services->get('proposal_session_service');
        $proposal       = $services->get('proposal_service');
        $controller     = new LoanController();
        $controller->setProposalService($proposal);
        $controller->setProposalSession($session);
        $controller->setEntityManager($entitymanager);
        $controller->setSearchQuery($services->get('proposal_search_query'));
        $controller->setRepository('DtlProposal\Entity\Loan');
        return $controller;
    }
}
