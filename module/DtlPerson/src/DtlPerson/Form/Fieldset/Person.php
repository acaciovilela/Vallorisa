<?php

namespace DtlPerson\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use DtlPerson\Entity\Person as PersonEntity;

class Person extends Fieldset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('person');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new PersonEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'type',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'required' => 'required',
                'placeholder' => 'Nome',
                'class' => 'form-control ',
            ),
            'options' => array(
               'label' => 'Nome'
            ),
        ));
        
        $address = new \DtlPerson\Form\Fieldset\Address($entityManager);
        $address->setLabel('Dados de Endereço')
                ->setName('address');
        $this->add($address);

        $contact = new Contact($entityManager);
        $contact->setName('contact')
                ->setLabel('Dados de Contato');
        $this->add($contact);
        
        $individual = new Individual($entityManager);
        $individual->setName('individual')
                ->setLabel('Dados de Pessoa Física');
        $this->add($individual);
        
        $legal = new Legal($entityManager);
        $legal->setName('legal')
                ->setLabel('Dados de Pessoa Jurídica');
        $this->add($legal);
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true
            ),
        );
    }
}
