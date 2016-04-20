<?php

namespace DtlCurrentAccount\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlCurrentAccount\Entity\CurrentAccount as CurrentAccountEntity;
use DtlCurrentAccount\Form\Fieldset\CurrentAccount as CurrentAccountFieldset;

class CurrentAccount extends Form {

    public function __construct($entityManager) {

        parent::__construct('currentAccount');

        $hydrator = new DoctrineHydrator($entityManager);

        $this->setHydrator($hydrator)
                ->setObject(new CurrentAccountEntity())
                ->setInputFilter(new InputFilter())
                ->setAttribute('method', 'post');

        $currentAccount = new CurrentAccountFieldset($entityManager);
        $currentAccount->setName('currentAccount')
                ->setOptions(array(
                    'use_as_base_fieldset' => true
                ))
                ->setLabel('Conta Corrente');
        $this->add($currentAccount);

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'security'
        ));

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
                'onclick' => "javascript: window.location.href = '/admin/currentaccount'",
            )
        ));
    }

}
