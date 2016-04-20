<?php

namespace DtlCurrentAccount\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlCurrentAccount\Entity\CurrentAccount as CurrentAccountEntity;

class CurrentAccount extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('currentAccount');

        $hydrator = new DoctrineHydrator($entityManager);

        $this->setHydrator($hydrator)
                ->setObject(new CurrentAccountEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'bank',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Banco',
                'object_manager' => $entityManager,
                'target_class' => 'DtlBank\Entity\Bank',
                'property' => 'name',
                'empty_option' => 'Banco',
                'is_method' => false,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC')
                    )
                )
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
            )
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Nome da Conta',
                'class' => 'form-control input-sm',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Nome da Conta'
            ),
        ));

        $this->add(array(
            'name' => 'agency',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Agência',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Agência'
            ),
        ));

        $this->add(array(
            'name' => 'agencyVd',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Dig.',
                'class' => 'form-control input-sm',
                'maxlength' => 1
            ),
            'options' => array(
                'label' => 'DV'
            ),
        ));

        $this->add(array(
            'name' => 'account',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Nº da Conta',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Nº da Conta'
            ),
        ));

        $this->add(array(
            'name' => 'accountVd',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Dig.',
                'class' => 'form-control input-sm',
                'maxlength' => 1
            ),
            'options' => array(
                'label' => 'DV'
            ),
        ));

        $this->add(array(
            'name' => 'manager',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Nome do Gerente',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Gerente'
            ),
        ));

        $this->add(array(
            'name' => 'managerPhone',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Tel. do Gerente',
                'class' => 'form-control input-sm phone',
            ),
            'options' => array(
                'label' => 'Telefone'
            ),
        ));

        $this->add(array(
            'name' => 'managerEmail',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Email do Gerente',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'E-mail'
            ),
        ));

        $this->add(array(
            'name' => 'bankWebsite',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Site do Banco',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Website'
            ),
        ));

        $this->add(array(
            'name' => 'creditLimit',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Limite',
                'class' => 'form-control input-sm currency',
            ),
            'options' => array(
                'label' => 'Limite de Crédito'
            ),
        ));

        $this->add(array(
            'name' => 'expiration',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Venc. Limite',
                'class' => 'form-control input-sm datepicker',
            ),
            'options' => array(
                'label' => 'Data de Venc.'
            ),
        ));

        $this->add(array(
            'name' => 'openDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Aberta Em',
                'class' => 'form-control input-sm datepicker',
            ),
            'options' => array(
                'label' => 'Aberta em'
            ),
        ));

        $this->add(array(
            'name' => 'openBalance',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Saldo Inicial',
                'class' => 'form-control input-sm currency',
            ),
            'options' => array(
                'label' => 'Saldo Inicial'
            ),
        ));

        $this->add(array(
            'name' => 'currency',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Moeda',
                'object_manager' => $entityManager,
                'target_class' => 'DtlCurrency\Entity\Currency',
                'property' => 'name',
                'empty_option' => 'Moeda',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC')
                    )
                )
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));

        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'placeholder' => 'Descrição',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Descrição'
            ),
        ));

        $this->add(new CreditCard($entityManager));
    }

    public function getInputFilterSpecification() {
        return array(
            'bank' => array(
                'required' => false,
            ),
            'currency' => array(
                'required' => false,
            ),
            'name' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                )
            ),
            'agency' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                    array('name' => 'Alnum'),
                )
            ),
            'agencyVd' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                    array('name' => 'Alnum'),
                )
            ),
            'account' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                    array('name' => 'Alnum'),
                )
            ),
            'accountDv' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                    array('name' => 'Alnum'),
                )
            ),
            'manager' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                    array('name' => 'Alnum'),
                )
            ),
            'managerPhone' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                    array('name' => 'Digits'),
                )
            ),
            'managerEmail' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                ),
                'validators' => array(
                    array('name' => 'EmailAddress')
                )
            ),
            'bankWebsite' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                ),
            ),
            'limit' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'expiration' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
//                    new \DtlBase\Filter\Date()
                ),
            ),
            'openDate' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
//                    new \DtlBase\Filter\Date()
                ),
            ),
            'openBalance' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
        );
    }

}
