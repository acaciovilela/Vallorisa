<?php

namespace DtlRealtor\Form;

use DtlRealtor\Entity\Realtor as RealtorEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form;

class Realtor extends Form {

    public function __construct($entityManager) {

        parent::__construct('realtor');
        
        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RealtorEntity())
                ->setInputFilter(new InputFilter());

        $realtor = new Fieldset\Realtor($entityManager);
        $realtor->setUseAsBaseFieldset(true)
                ->setName('realtor');
        $this->add($realtor);
        
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
                'onclick' => "javascript: window.location.href = '/admin/realtor'",
            )
        ));
    }
}
