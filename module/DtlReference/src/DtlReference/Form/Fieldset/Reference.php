<?php

namespace DtlReference\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlReference\Entity\Reference as ReferenceEntity;

class Reference extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {

        parent::__construct('reference');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ReferenceEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'type',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'reference_type',
                'placeholder' => 'Tipo',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Tipo',
                'empty_option' => 'Tipo',
                'value_options' => array(
                    'COMERCIAL' => 'COMERCIAL',
                    'CONTADOR' => 'CONTADOR',
                    'EXECUTIVA' => 'EXECUTIVA',
                    'PESSOAL' => 'PESSOAL',
                )
            ),
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'reference_name',
                'placeholder' => 'Referência',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Referência'
            ),
        ));

        $this->add(array(
            'name' => 'phone',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'reference_phone',
                'placeholder' => 'Telefone',
                'class' => 'form-control input-sm phone',
            ),
            'options' => array(
                'label' => 'Telefone'
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array();
    }

}
