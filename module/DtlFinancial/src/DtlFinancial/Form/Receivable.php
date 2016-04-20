<?php

namespace DtlFinancial\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlFinancial\Entity\Receivable as ReceivableEntity;

class Receivable extends Form {

    public function __construct($entityManager, $user) {

        parent::__construct('receivable');
        
        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ReceivableEntity())
                ->setInputFilter(new InputFilter());
        
        $receivable = new Fieldset\Receivable($entityManager, $user);
        $receivable->setUseAsBaseFieldset(true);
        $this->add($receivable);
        
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
                'onclick' => "javascript: window.location.href = '/admin/financial/receivable'",
            )
        ));
    }
}
