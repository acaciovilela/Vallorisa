<?php

namespace DtlFinancial\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlFinancial\Entity\Launch as LaunchEntity;

class Launch extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $user, $true = 1) {
        parent::__construct('launch');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new LaunchEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'date',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm datepicker',
                'value' => date('d/m/Y')
            ),
            'options' => array(
                'label' => 'Data de Lançamento',
            ),
        ));

        $this->add(array(
            'name' => 'number',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Número',
            )
        ));

        $this->add(array(
            'name' => 'value',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'placeholder' => '0,00'
            ),
            'options' => array(
                'label' => 'Valor',
            )
        ));

        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Descrição',
            )
        ));

        $this->add(array(
            'name' => 'currentAccount',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Conta Corrente',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlCurrentAccount\Entity\CurrentAccount',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array('user' => $user),
                        'orderBy' => array('name' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));

        $this->add(array(
            'name' => 'accountingItem',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Ítem Contábil',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlAccountingItem\Entity\AccountingItem',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'user' => $user,
                            'type' => $true,
                        ),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'value' => array(
                'required' => true,
                'filters' => array(
                    new \DtlBase\Filter\Currency()
                ),
            ),
            'date' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Date()
                ),
            ),
            'currentAccount' => array(
                'required' => true,
            ),
            'accountingItem' => array(
                'required' => true,
            ),
        );
    }
}
