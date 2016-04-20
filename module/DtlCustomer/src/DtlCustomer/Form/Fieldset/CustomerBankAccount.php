<?php

namespace DtlCustomer\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;

class CustomerBankAccount extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $id) {
        parent::__construct('customerBankAccount');

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'customer',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'object_manager' => $entityManager,
                'target_class' => 'DtlCustomer\Entity\Customer',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('id' => $id),
                    )
                ),
                'label' => 'Cliente'
            ),
            'attributes' => array(
                'id' => 'customer_id',
                'class' => 'form-control input-sm',
            )
        ));

        $bankAccount = new \DtlBankAccount\Form\Fieldset\BankAccount($entityManager);
        $bankAccount->setName('bankAccount')
                ->setLabel('Conta Bancária');
        $this->add($bankAccount);
    }

    public function getInputFilterSpecification() {
        return array();
    }

}
