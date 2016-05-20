<?php

namespace DtlAccountingItem\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlAccountingItem\Entity\AccountingItem as AccountingItemEntity;

class AccountingItem extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('accountingItem');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new AccountingItemEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Item Contábil',
                'class'         => 'form-control input-sm',
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Ítem Contábil'
            )
        ));
        
        $this->add(array(
            'name' => 'type',
            'type' => 'Zend\Form\Element\Radio',
            'options' => array(
                'value_options' => array(
                    '1' => 'Entrada',
                    '0' => 'Saída'
                ),
            ),
            'attributes' => array(
                'required' => 'required',
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true,
            ),
            'type' => array(
                'required' => true,
            )
        );
    }
}
