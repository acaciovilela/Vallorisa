<?php

namespace DtlProposal\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlProposal\Service\Proposal;

class ProposalServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $sm) {
        $service = new Proposal();
        $service->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        $service->setProposalSession($sm->get('proposal_session_service'));
        return $service;
    }
}
