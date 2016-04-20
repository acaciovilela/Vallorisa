<?php

namespace DtlProposal\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class Search extends Form {

    public function __construct($entityManager, $user) {

        parent::__construct('search');

        $this->setAttribute('method', 'post')
                ->setInputFilter(new InputFilter());
        
        $search = new Fieldset\Search($entityManager, $user);
        $search->setUseAsBaseFieldset(true);
        $this->add($search);
        
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
