<?php

namespace DtlBank\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlBank\Entity\Bank as BankEntity;

class Bank extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('bank');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new BankEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'code',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Número',
                'class'         => 'form-control ',
                'required'      => 'required',
                'maxlength'     => 4
            ),
            'options' => array(
                'label' => 'Código'
            ),
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Nome do Banco',
                'class'         => 'form-control ',
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Nome do Banco'
            ),
        ));
        
        $this->add(array(
            'name' => 'url',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Site do Banco',
                'class'         => 'form-control ',
            ),
            'options' => array(
                'label' => 'Site do Banco'
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'code' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'Digits'),
                )
            ),
            'name' => array(
                'required' => true,
            ),
            'url' => array(
                'required' => false,
            ),
        );
    }

}
