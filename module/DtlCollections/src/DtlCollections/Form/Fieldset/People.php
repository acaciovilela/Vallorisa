<?php

namespace DtlCollections\Form\Fieldset;

use Zend\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use DtlCollections\Entity\People as PeopleEntity;

class People extends Fieldset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('people');
        
        $this->setLabel('Dados Pessoais');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new PeopleEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'attributes' => array(
                'required' => 'required',
                'placeholder' => 'Nome',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
               'label' => 'Nome'
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true
            ),
        );
    }
}
