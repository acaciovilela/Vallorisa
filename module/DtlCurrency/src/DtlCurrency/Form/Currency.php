<?php

namespace DtlCurrency\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlCurrency\Entity\Currency as CurrencyEntity;

class Currency extends Form {

    public function __construct($entityManager) {

        parent::__construct('currency');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new CurrencyEntity())
                ->setInputFilter(new InputFilter());
        
        $currency = new Fieldset\Currency($entityManager);
        $currency->setUseAsBaseFieldset(true)
                ->setName('currency');
        $this->add($currency);
        
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
                'onclick' => "javascript: window.location.href = '/admin/currency'",
            )
        ));
    }
}
