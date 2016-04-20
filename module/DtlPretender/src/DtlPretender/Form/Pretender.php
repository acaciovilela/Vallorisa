<?php

namespace DtlPretender\Form;

use DtlPretender\Entity\Pretender as PretenderEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form;

class Pretender extends Form {

    public function __construct($entityManager) {

        parent::__construct('pretender_form');
        
        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new PretenderEntity())
                ->setInputFilter(new InputFilter());

        $pretender = new Fieldset\Pretender($entityManager);
        $pretender->setUseAsBaseFieldset(true);
        $this->add($pretender);

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
                'onclick' => "javascript: window.location.href = '/admin/pretender'",
            )
        ));
    }
}
