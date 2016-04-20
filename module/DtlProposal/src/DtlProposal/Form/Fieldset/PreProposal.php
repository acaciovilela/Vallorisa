<?php

namespace DtlProposal\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;

class PreProposal extends ZendFielset implements InputFilterProviderInterface {

    public function __construct() {

        parent::__construct('preProposal');

        $this->add(array(
            'name' => 'type',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Tipo de Cliente',
                'empty_option' => 'SELECIONE',
                'value_options' => array(
                    'MA==' => 'PESSOA FÍSICA',
                    'MQ==' => 'PESSOA JURÍDICA',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'onchange' => 'javascript: changePerson(this.value);',
                'id' => 'personType'
            ),
        ));
        
        $this->add(array(
            'name' => 'cpf',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'CPF',
                'class' => 'form-control input-sm cpf',
                'id' => 'cpf',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'CPF'
            ),
        ));
        
        $this->add(array(
            'name' => 'cnpj',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'CNPJ',
                'class' => 'form-control input-sm cnpj',
                'id' => 'cnpj',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'CNPJ'
            ),
        ));
        
        $this->add(array(
            'name' => 'document',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'disabled' => 'disabled',
                'id' => 'personDocument'
            ),
            'options' => array(
                'label' => 'CPF/CNPJ',
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'cpf' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\Filter\Digits(),
                ),
                'validators' => array( 
                    new \DtlBase\Validator\Cpf(),
                ),
            ),
            'cnpj' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\Filter\Digits(),
                ),
                'validators' => array( 
                    new \DtlBase\Validator\Cnpj(),
                ),
            ),
        );
    }

}
