<?php

namespace DtlAccountingItem\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlAccountingItem\Entity\AccountingItem as AccountingItemEntity;

class AccountingItem extends Form {

    public function __construct($entityManager) {

        parent::__construct('accounting_item_form');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new AccountingItemEntity())
                ->setInputFilter(new InputFilter());
        
        $accountingItem = new Fieldset\AccountingItem($entityManager);
        $accountingItem->setUseAsBaseFieldset(true);
        $this->add($accountingItem);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
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
                'onclick' => "javascript: window.location.href = '/admin/accounting-item'",
            )
        ));
    }
}
