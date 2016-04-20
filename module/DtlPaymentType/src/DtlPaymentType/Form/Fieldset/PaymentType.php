<?php

namespace DtlPaymentType\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlPaymentType\Entity\PaymentType as PaymentTypeEntity;

class PaymentType extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('paymentType');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new PaymentTypeEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Forma de Pagamento',
                'class'         => 'form-control',
                'data-bv-notempty' => 'true'
            ),
            'options' => array(
                'label' => 'Forma de Pagamento'
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\Filter\StringTrim()
                )
            ),
        );
    }

}
