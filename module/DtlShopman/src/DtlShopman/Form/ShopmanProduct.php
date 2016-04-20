<?php

namespace DtlShopman\Form;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form;

class ShopmanProduct extends Form {

    public function __construct($entityManager) {

        parent::__construct('shopmanProduct');
        
        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setInputFilter(new InputFilter());

        $shopman = new Fieldset\ShopmanProduct($entityManager);
        $shopman->setUseAsBaseFieldset(true)
                ->setName('shopmanProduct');
        $this->add($shopman);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'security'
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Adicionar',
                'class' => 'btn btn-primary',
            )
        ));

        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Cancel',
                'class' => 'btn btn-default',
                'onclick' => "javascript: window.location.href = '/admin/shopman'",
            )
        ));
    }
}
