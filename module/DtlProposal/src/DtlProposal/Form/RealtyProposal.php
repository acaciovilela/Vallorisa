<?php

namespace DtlProposal\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlProposal\Entity\RealtyProposal as RealtyProposalEntity;

class RealtyProposal extends Form {

    public function __construct($entityManager, $user) {

        parent::__construct('realtyProposal');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RealtyProposalEntity())
                ->setInputFilter(new InputFilter());

        $realtyProposal = new Fieldset\RealtyProposal($entityManager, $user);
        $realtyProposal->setUseAsBaseFieldset(true);
        $this->add($realtyProposal);
        
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
                'onclick' => 'javascript: window.location.href = "/admin/proposal/realty-proposal";'
            )
        ));
    }
}
