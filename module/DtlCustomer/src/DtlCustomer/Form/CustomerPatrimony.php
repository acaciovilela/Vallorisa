<?php

namespace DtlCustomer\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class CustomerPatrimony extends Form {

    public function __construct($entityManager, $id) {

        parent::__construct('customerPatrimony');

        $this->setAttribute('method', 'post')
                ->setInputFilter(new InputFilter());
        
        $customerPatrimony = new \DtlCustomer\Form\Fieldset\CustomerPatrimony($entityManager, $id);
        $customerPatrimony->setUseAsBaseFieldset(true);
        $this->add($customerPatrimony);
        
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
                'onclick' => 'javascript: customerPatrimonyPost();'
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
