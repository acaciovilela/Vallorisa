<?php

namespace DtlSeller\Form;

use DtlSeller\Entity\Seller as SellerEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form;

class Seller extends Form {

    public function __construct($entityManager) {

        parent::__construct('seller');
        
        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new SellerEntity())
                ->setInputFilter(new InputFilter());

        $seller = new Fieldset\Seller($entityManager);
        $seller->setUseAsBaseFieldset(true)
                ->setName('seller');
        $this->add($seller);
        
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
                'onclick' => "javascript: window.location.href = '/admin/seller'",
            )
        ));
    }
}
