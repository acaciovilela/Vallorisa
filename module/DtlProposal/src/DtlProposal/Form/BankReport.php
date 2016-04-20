<?php

namespace DtlProposal\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class BankReport extends Form {

    public function __construct($entityManager) {

        parent::__construct('bankReport');

        $this->setAttribute('method', 'post')
                ->setInputFilter(new InputFilter());
        
        $bankReport = new Fieldset\BankReport($entityManager);
        $bankReport->setUseAsBaseFieldset(true);
        $this->add($bankReport);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-primary'
            )
        ));
    }
}
