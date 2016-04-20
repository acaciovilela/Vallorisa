<?php

namespace DtlCustomer\Form;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlCustomer\Entity\Customer as CustomerEntity;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form;

class Customer extends Form {

    public function __construct($entityManager) {

        parent::__construct('customer');
        
        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new CustomerEntity())
                ->setInputFilter(new InputFilter());

        $customer = new Fieldset\Customer($entityManager);
        $customer->setUseAsBaseFieldset(true)
                ->setName('customer');
        $this->add($customer);
        
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
                'onclick' => "javascript: window.location.href = '/admin/customer'",
            )
        ));
    }
}
