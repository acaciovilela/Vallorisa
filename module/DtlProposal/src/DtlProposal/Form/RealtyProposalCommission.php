<?php

namespace DtlProposal\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlProposal\Entity\RealtyProposalCommission as RealtyProposalCommissionEntity;

class RealtyProposalCommission extends Form {

    public function __construct($entityManager) {

        parent::__construct('realtyProposalCommission');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RealtyProposalCommissionEntity())
                ->setInputFilter(new InputFilter());

        $realtyProposal = new Fieldset\RealtyProposalCommission($entityManager);
        $realtyProposal->setUseAsBaseFieldset(true);
        $this->add($realtyProposal);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'security'
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-primary'
            )
        ));

        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Cancel',
                'class' => 'btn btn-default',
                'onclick' => 'javascript: window.location.href = "/admin/proposal/realty-proposal-commission";'
            )
        ));
    }
}
