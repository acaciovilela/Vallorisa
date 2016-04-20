<?php

namespace DtlPerson\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use DtlPerson\Entity\Contact as ContactEntity;

class Contact extends Fieldset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('contact');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ContactEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'attributes' => array(
                'placeholder' => 'E-mail',
                'class' => 'form-control ',
            ),
            'options' => array(
                'label' => 'E-mail'
            ),
        ));

        $this->add(array(
            'name' => 'url',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Website',
                'class' => 'form-control ',
            ),
            'options' => array(
                'label' => 'Website'
            ),
        ));

        $this->add(array(
            'name' => 'phone',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Telefone',
                'class' => 'form-control  phone',
            ),
            'options' => array(
                'label' => 'Telefone'
            ),
        ));

        $this->add(array(
            'name' => 'cell',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Celular',
                'class' => 'form-control  phone',
            ),
            'options' => array(
                'label' => 'Celular'
            ),
        ));

        $this->add(array(
            'name' => 'fax',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'FAX',
                'class' => 'form-control  phone',
            ),
            'options' => array(
                'label' => 'Fax'
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'email' => array(
                'required' => false,
                'validators' => array(
                    array('name' => 'EmailAddress'),
                ),
                'filters' => array(
                    array('name' => 'StringToLower')
                )
            ),
            'url' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringToLower') 
                ),
            ),
            'phone' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'Digits'),
                )
            ),
            'cell' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'Digits'),
                )
            ),
            'fax' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'Digits'),
                )
            ),
        );
    }
}
