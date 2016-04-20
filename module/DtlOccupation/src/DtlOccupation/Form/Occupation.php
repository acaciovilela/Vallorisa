<?php

namespace DtlOccupation\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlOccupation\Entity\Occupation as OccupationEntity;

class Occupation extends Form {

    public function __construct($entityManager) {

        parent::__construct('occupation');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new OccupationEntity())
                ->setInputFilter(new InputFilter());
        
        $occupation = new \DtlOccupation\Form\Fieldset\Occupation($entityManager);
        $occupation->setUseAsBaseFieldset(true)
                ->setName('occupation');
        $this->add($occupation);
        
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
                'onclick' => "javascript: window.location.href = '/admin/occupation'",
            )
        ));
    }
}
