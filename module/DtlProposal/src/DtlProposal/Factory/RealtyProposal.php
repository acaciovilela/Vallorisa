<?php

namespace DtlProposal\Factory;

use DtlProposal\Controller\RealtyProposalController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RealtyProposal implements FactoryInterface {

    public function createService(ServiceLocatorInterface $controllers) {
        $sm = $controllers->getServiceLocator();
        $fm = $sm->get('FormElementManager');
        $em = $sm->get('doctrine.entitymanager.orm_default');
        $controller = new RealtyProposalController();
        $controller->setProposalSession($sm->get('proposal_session_service'));
        $controller->setProposalService($sm->get('proposal_service'));
        $controller->setEntityManager($em);
        $controller->setSearchQuery($sm->get('proposal_search_query'));
        $controller->setRepository('DtlProposal\Entity\RealtyProposal');
        $controller->setForm($fm->get('realty_proposal_form'));
        return $controller;
    }

}
