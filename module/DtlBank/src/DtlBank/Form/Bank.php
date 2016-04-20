<?php

namespace DtlBank\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlBank\Entity\Bank as BankEntity;

class Bank extends Form {

    public function __construct($entityManager) {

        parent::__construct('bank_form');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new BankEntity())
                ->setInputFilter(new InputFilter());
        
        $bank = new Fieldset\Bank($entityManager);
        $bank->setUseAsBaseFieldset(true)
                ->setName('bank');
        $this->add($bank);
        
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
                'value' => 'Cancel',
                'class' => 'btn btn-default',
                'onclick' => "javascript: window.location.href = '/admin/bank'",
            )
        ));
    }
}
