<?php

namespace DtlLocation\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlLocation\Entity\State as StateEntity;

class State extends Form {

    public function __construct($entityManager) {

        parent::__construct('state');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new StateEntity())
                ->setInputFilter(new InputFilter());
        
        $state = new Fieldset\State($entityManager);
        $state->setUseAsBaseFieldset(true);
        $this->add($state);
        
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
                'onclick' => "javascript: window.location.href = '/admin/location/state'",
            )
        ));
    }
}
