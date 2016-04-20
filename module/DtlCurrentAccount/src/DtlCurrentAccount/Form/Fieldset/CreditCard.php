<?php

namespace DtlCurrentAccount\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlCurrentAccount\Entity\CreditCard as CreditCardEntity;

class CreditCard extends ZendFielset implements InputFilterProviderInterface {

    private $brands = array(
        'americanexpress' => 'AMERICAN EXPRESS',
        'dinersclub' => 'DINERS CLUB',
        'greencard' => 'GREENCARD',
        'maestro' => 'MAESTRO',
        'mastercard' => 'MASTERCARD',
        'redeshop' => 'REDE SHOP',
        'visa' => 'VISA',
        'visaelectron' => 'VISA ELECTRON',
    );

    public function __construct($entityManager) {
        parent::__construct('creditCard');

        

        $hydrator = new DoctrineHydrator($entityManager);

        $this->setHydrator($hydrator)
                ->setObject(new CreditCardEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'number',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Número do Cartão',
                'class' => 'form-control input-sm creditcard',
            ),
            'options' => array(
                'label' => 'Número do Cartão'
            )
        ));

        $this->add(array(
            'name' => 'brand',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'placeholder' => 'Bandeira',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'empty_option' => '',
                'value_options' => $this->brands,
                'label' => 'Bandeira'
            ),
        ));

        $this->add(array(
            'name' => 'closing',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'placeholder' => 'Fechamento',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'empty_option' => '',
                'value_options' => range(1, 28),
                'label' => 'Fechamento'
            )
        ));

        $this->add(array(
            'name' => 'expiration',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'placeholder' => 'Vencimento',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'empty_option' => '',
                'value_options' => range(1, 28),
                'label' => 'Vencimento'
            )
        ));

        $this->add(array(
            'name' => 'validity',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm validity',
            ),
            'options' => array(
                'label' => 'Dt. de Validade'
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'number' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                    array('name' => 'Digits'),
                ),
                'validators' => array(
                    array('name' => 'CreditCard')
                )
            ),
            'validity' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags'),
                    array('name' => 'Digits'),
                ),
            ),
            'brand' => array(
                'required' => false,
            ),
            'closing' => array(
                'required' => false,
            ),
            'expiration' => array(
                'required' => false,
            ),
        );
    }

}
