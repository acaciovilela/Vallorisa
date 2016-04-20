<?php

namespace DtlBankAccount\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlBankAccount\Entity\BankAccount as BankAccountEntity;

class BankAccount extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('bankAccount');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new BankAccountEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'type',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'bank_account_type',
                'placeholder' => 'Tipo da Conta',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'empty_option' => 'Tipo da Conta',
                'value_options' => array(
                    'CONTA CORRENTE INDIVIDUAL' => 'CONTA CORRENTE INDIVIDUAL',
                    'CONTA CORRENTE CONJUNTA' => 'CONTA CORRENTE CONJUNTA',
                    'CONTA POUPANÇA INDIVIDUAL' => 'CONTA POUPANÇA INDIVIDUAL',
                    'CONTA POUPANÇA CONJUNTA' => 'CONTA POUPANÇA CONJUNTA',
                    'ORDEM DE PAGAMENTO' => 'ORDEM DE PAGAMENTO',
                ),
                'label' => 'Tipo da Conta'
            ),
        ));

        $this->add(array(
            'name' => 'bankName',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'bank_account_bank',
                'placeholder' => 'Banco',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Banco'
            ),
        ));

        $this->add(array(
            'name' => 'agency',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'bank_account_agency',
                'placeholder' => 'Agência',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Agência'
            ),
        ));

        $this->add(array(
            'name' => 'account',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'bank_account_account',
                'placeholder' => 'Conta',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Conta'
            ),
        ));

        $this->add(array(
            'name' => 'since',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'bank_account_since',
                'placeholder' => 'Cliente Desde',
                'class' => 'form-control input-sm datepicker',
            ),
            'options' => array(
                'label' => 'Cliente Desde'
            ),
        ));

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
                'id' => 'bank'
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'since' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'DtlBase\Filter\Date',
                    )
                )
            ),
            'type' => array(
                'required' => false,
            ),
            'bank' => array(
                'required' => false,
            ),
        );
    }

}
