<?php

namespace DtlProposal\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlProposal\Form\RealtyProposal as RealtyProposalForm;

class RealtyProposalFormFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sm = $serviceLocator->getServiceLocator();
        $form = new RealtyProposalForm();
        $form->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        return $form;
    }

}
