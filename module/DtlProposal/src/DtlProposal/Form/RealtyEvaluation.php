<?php

namespace DtlProposal\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class RealtyEvaluation extends Form {

    public function __construct($entityManager) {

        parent::__construct('realtyEvaluation');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setAttribute('method', 'post')
                ->setInputFilter(new InputFilter());
        
        $realtyEvaluation = new Fieldset\RealtyEvaluation($entityManager);
        $realtyEvaluation->setUseAsBaseFieldset(true);
        $this->add($realtyEvaluation);
        
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
    }
}
