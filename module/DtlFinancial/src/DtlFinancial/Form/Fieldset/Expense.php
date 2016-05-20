<?php

namespace DtlFinancial\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlFinancial\Entity\Expense as ExpenseEntity;

class Expense extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $user) {
        parent::__construct('expense');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ExpenseEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'supplier',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Fornecedor',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlSupplier\Entity\Supplier',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'supplierList',
                    'params' => array(
                        'user' => $user
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
            )
        ));

        $launch = new Launch($entityManager, $user, 0);
        $this->add($launch);
    }

    public function getInputFilterSpecification() {
        return array(
            'supplier' => array(
                'required' => true,
            ),
        );
    }

}
