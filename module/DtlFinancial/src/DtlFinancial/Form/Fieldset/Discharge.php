<?php

namespace DtlFinancial\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlFinancial\Entity\Discharge as DischargeEntity;

class Discharge extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('discharge');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new DischargeEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'parcel',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'date',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control  datepicker',
            ),
            'options' => array(
                'label' => 'Data da Baixa',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'value',
            'attributes' => array(
                'class' => 'form-control  currency',
            ),
            'options' => array(
                'label' => 'Valor a Baixar'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Button',
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Efetuar Baixa',
                'class' => 'btn btn-primary'
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'date' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Date()
                ),
            ),
            'value' => array(
                'required' => false,
                'filters' => array(
                ),
            ),
        );
    }
}
