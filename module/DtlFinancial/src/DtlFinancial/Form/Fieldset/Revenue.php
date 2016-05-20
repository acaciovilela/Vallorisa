<?php

namespace DtlFinancial\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlFinancial\Entity\Revenue as RevenueEntity;

class Revenue extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $user) {
        parent::__construct('revenue');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RevenueEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'customer',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Recebido de',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlCustomer\Entity\Customer',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'customerList',
                    'params' => array(
                        'user' => $user,
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));

        $launch = new Launch($entityManager, $user);
        $this->add($launch);
    }

    public function getInputFilterSpecification() {
        return array(
            'customer' => array(
                'required' => true,
            )
        );
    }

}
