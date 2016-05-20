<?php

namespace DtlProposal\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlProposal\Entity\LoanProposal as LoanEntity;

class LoanProposal extends Form {

    public function __construct($entityManager, $user) {

        parent::__construct('loan');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new LoanEntity())
                ->setInputFilter(new InputFilter());

        $loan = new Fieldset\LoanProposal($entityManager, $user);
        $loan->setUseAsBaseFieldset(true);
        $this->add($loan);
        
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
                'onclick' => 'javascript: window.location.href = "/admin/proposal/loan-proposal";'
            )
        ));
    }
}
