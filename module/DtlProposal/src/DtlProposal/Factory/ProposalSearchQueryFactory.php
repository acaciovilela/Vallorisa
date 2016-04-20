<?php

namespace DtlProposal\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlProposal\Service\ProposalSearchQuery;

class ProposalSearchQueryFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $sm) {
        $service = new ProposalSearchQuery();
        $service->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        return $service;
    }
}
