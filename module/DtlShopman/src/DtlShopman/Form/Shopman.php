<?php

namespace DtlShopman\Form;

use DtlShopman\Entity\Shopman as ShopmanEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form;

class Shopman extends Form {

    public function __construct($entityManager) {

        parent::__construct('shopman');
        
        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ShopmanEntity())
                ->setInputFilter(new InputFilter());

        $shopman = new Fieldset\Shopman($entityManager);
        $shopman->setUseAsBaseFieldset(true)
                ->setName('shopman');
        $this->add($shopman);
        
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
                'onclick' => "javascript: window.location.href = '/admin/shopman'",
            )
        ));
    }
}
