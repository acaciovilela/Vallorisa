<?php

namespace DtlCustomer\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class CustomerVehicle extends Form {

    public function __construct($entityManager, $id) {

        parent::__construct('customerVehicle');

        $this->setAttribute('method', 'post')
                ->setInputFilter(new InputFilter());
        
        $customerVehicle = new \DtlCustomer\Form\Fieldset\CustomerVehicle($entityManager, $id);
        $customerVehicle->setUseAsBaseFieldset(true);
        $this->add($customerVehicle);
        
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
                'onclick' => 'javascript: customerVehiclePost();'
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
