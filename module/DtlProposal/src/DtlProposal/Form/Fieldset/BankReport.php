<?php

namespace DtlProposal\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;

class BankReport extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('bankReport');
        
        $this->add(array(
            'name' => 'bank',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Banco',
                'empty_option' => 'Selecione o Banco',
                'object_manager' => $entityManager,
                'target_class' => 'DtlBank\Entity\Bank',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC')
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
            )
        ));
        
        $this->add(array(
            'name' => 'parcelAmount',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'parcelAmount',
            ),
            'options' => array(
                'label' => 'Parcelas'
            ),
        ));
        
        $this->add(array(
            'name' => 'parcelValue',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'parcelValue',
                'placeholder' => '0,00'
            ),
            'options' => array(
                'label' => 'Valor da Parcela'
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'bank' => array(
                'required' => true,
            ),
            'parcelValue' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Currency(),
                ),
            ),
        );
    }
}
