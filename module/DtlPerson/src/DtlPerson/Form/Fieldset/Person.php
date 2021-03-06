<?php

namespace DtlPerson\Form\Fieldset;

use Zend\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use DtlPerson\Entity\Person as PersonEntity;

class Person extends Fieldset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('person');
        
        $this->setLabel('Dados Pessoais');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new PersonEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        
        $this->add(array(
            'name' => 'type',
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
        
        $this->add(new Address($entityManager));

        $this->add(new Contact($entityManager));
        
        $this->add(new Individual($entityManager));
        
        $this->add(new Legal($entityManager));
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true
            ),
        );
    }
}
