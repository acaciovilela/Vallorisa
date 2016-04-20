<?php

namespace DtlOffice\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlOffice\Entity\Office as OfficeEntity;

class Office extends Form {

    public function __construct($entityManager) {

        parent::__construct('office');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new OfficeEntity())
                ->setInputFilter(new InputFilter());
        
        $office = new Fieldset\Office($entityManager);
        $office->setUseAsBaseFieldset(true);
        $this->add($office);
        
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
                'onclick' => "javascript: window.location.href = '/admin/office'",
            )
        ));
    }
}
