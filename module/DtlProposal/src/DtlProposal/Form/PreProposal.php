<?php

namespace DtlProposal\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class PreProposal extends Form {

    public function __construct() {

        parent::__construct('preProposal');

        $this->setAttribute('method', 'post')
                ->setInputFilter(new InputFilter());
        
        $preProposal = new Fieldset\PreProposal();
        $preProposal->setUseAsBaseFieldset(true);
        $this->add($preProposal);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'security'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Continuar',
                'class' => 'btn btn-primary'
            )
        ));

        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Cancelar',
                'class' => 'btn btn-default',
            )
        ));
    }
}
