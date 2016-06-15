<?php

namespace DtlPerson\Form\Fieldset;

use Zend\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use DtlPerson\Entity\Contact as ContactEntity;

class Contact extends Fieldset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('contact');

        $this->setLabel('Dados de Contato');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ContactEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'email',
            'type' => 'Email',
            'attributes' => array(
                'placeholder' => 'E-mail',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'E-mail'
            ),
        ));

        $this->add(array(
            'name' => 'url',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Website',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Website'
            ),
        ));

        $this->add(array(
            'name' => 'phone',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Telefone',
                'class' => 'form-control input-sm phone',
            ),
            'options' => array(
                'label' => 'Telefone'
            ),
        ));

        $this->add(array(
            'name' => 'cell',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Celular',
                'class' => 'form-control input-sm phone',
            ),
            'options' => array(
                'label' => 'Celular'
            ),
        ));

        $this->add(array(
            'name' => 'fax',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'FAX',
                'class' => 'form-control input-sm phone',
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
                ),
            ),
        );
    }
}
