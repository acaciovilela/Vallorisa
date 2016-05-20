<?php

namespace DtlPerson\Form;

use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Form;
use DtlPerson\Entity\Person as PersonEntity;

class Person extends Form {

    public function __construct($entityManager) {

        parent::__construct('person_form');
        
        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new PersonEntity())
                ->setInputFilter(new InputFilter());

        $person = new \DtlPerson\Form\Fieldset\Person($entityManager);
        $person->setUseAsBaseFieldset(true)
                ->setName('person');
        $this->add($person);
        
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
                'value' => 'Cancelar',
                'class' => 'btn btn-default',
                'onclick' => "javascript: window.location.href = '/person'",
            )
        ));
        
        $this->setValidationGroup(array(
            'security',
            'person' => array(
                'name',
                'address' => array(
                    'id',
                    'name',
                    'number',
                    'complement',
                    'quarter',
                    'postalCode',
                    'city',
                    'state',
                    'country',
                ),
                'contact' => array(
                    'id',
                    'email',
                    'url',
                    'phone',
                    'cell',
                    'fax',
                ),
                'individual' => array(
                    'cpf',
                    'rg',
                    'rgOrgan',
                    'rgUf',
                    'rgDate',
                    'birthDay',
                    'birthMonth',
                    'birthYear',
                    'birthPlace',
                    'birthUf',
                    'mother',
                    'father',
                    'nationality',
                    'gender',
                ),
                'legal' => array(
                    'id',
                    'cnpj',
                    'subscription',
                    'representativeName',
                    'representativePhone',
                )
            )
        ));
    }
}
