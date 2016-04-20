<?php

namespace DtlReport\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;


class ProductsByDate extends Form {

    public function __construct($entityManager) {

        parent::__construct('product_form');

        $this->setAttribute('method', 'post')
                ->setInputFilter(new InputFilter());
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'reportDateFrom',
            'attributes' => array(
                'class' => 'form-control datepicker',
                'placeholder' => 'Data Início'
            ),
            'options' => array(
                'label' => 'De',
                'label_attributes' => array(
                    'class' => 'col-sm-4 control-label'
                )
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'reportDateTo',
            'attributes' => array(
                'class' => 'form-control datepicker',
                'placeholder' => 'Data Fim'
            ),
            'options' => array(
                'label' => 'Até',
                'label_attributes' => array(
                    'class' => 'col-sm-4 control-label'
                )
            )
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
                'value' => 'Cancel',
                'class' => 'btn btn-default',
                'onclick' => "javascript: window.location.href = '/admin'",
            )
        ));
    }
}
