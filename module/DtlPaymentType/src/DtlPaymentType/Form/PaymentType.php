<?php

namespace DtlPaymentType\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlPaymentType\Entity\PaymentType as PaymentTypeEntity;

class PaymentType extends Form {

    public function __construct($entityManager) {

        parent::__construct('paymentType');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new PaymentTypeEntity())
                ->setInputFilter(new InputFilter());
        
        $this->setAttributes(array(
            'data-bv-feedbackicons-valid' => "glyphicon glyphicon-ok",
            'data-bv-feedbackicons-invalid' => "glyphicon glyphicon-remove",
            'data-bv-feedbackicons-validating' => "glyphicon glyphicon-refresh",
            'id' => 'paymentType'
        ));

        $paymentType = new Fieldset\PaymentType($entityManager);
        $paymentType->setUseAsBaseFieldset(true)
                ->setName('paymentType');
        $this->add($paymentType);

        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'save',
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
                'onclick' => "javascript: window.location.href = '/admin/payment-type'",
            )
        ));
    }

}
