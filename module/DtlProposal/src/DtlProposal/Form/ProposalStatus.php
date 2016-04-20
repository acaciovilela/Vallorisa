<?php

namespace DtlProposal\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class ProposalStatus extends Form {

    public function __construct() {

        parent::__construct('proposalStatus');

        $this->setAttribute('method', 'post')
                ->setInputFilter(new InputFilter());
        
        $proposalSatus = new Fieldset\ProposalStatus();
        $proposalSatus->setUseAsBaseFieldset(true);
        $this->add($proposalSatus);
        
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
