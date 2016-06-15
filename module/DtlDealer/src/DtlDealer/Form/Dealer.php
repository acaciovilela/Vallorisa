<?php

namespace DtlDealer\Form;

use DtlDealer\Entity\Dealer as DealerEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form;

class Dealer extends Form {

    public function __construct($entityManager) {

        parent::__construct('dealer');
        
        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new DealerEntity())
                ->setInputFilter(new InputFilter());

        $dealer = new Fieldset\Dealer($entityManager);
        $dealer->setUseAsBaseFieldset(true)
                ->setName('dealer');
        $this->add($dealer);
        
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
                'onclick' => "javascript: window.location.href = '/admin/dealer'",
            )
        ));
    }
}
