<?php

namespace DtlProposal\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use DtlProposal\Form\Fieldset\RealtyProposal as RealtyProposalFieldset;

class RealtyProposalFieldsetFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $sm = $serviceLocator->getServiceLocator();
        $fieldset = new RealtyProposalFieldset();
        $fieldset->setEntityManager($sm->get('doctrine.entitymanager.orm_default'));
        $fieldset->setUser($sm->get('zfcuser_user_service')->getAuthService()->getIdentity());
        return $fieldset;
    }
}
