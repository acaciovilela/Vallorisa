<?php

namespace DtlCustomer\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class CustomerReference extends Form {

    public function __construct($entityManager, $id) {

        parent::__construct('customerReference');

        $this->setAttribute('method', 'post')
                ->setInputFilter(new InputFilter());
        
        $customerReference = new \DtlCustomer\Form\Fieldset\CustomerReference($entityManager, $id);
        $customerReference->setUseAsBaseFieldset(true);
        $this->add($customerReference);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'security'
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Salvar',
                'class' => 'btn btn-primary',
                'onclick' => 'javascript: customerReferencePost();'
            ),
        ));

        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Voltar',
                'class' => 'btn btn-default',
                'onclick' => "javascript: window.location.href = '/admin/customer'",
            )
        ));
    }
}
