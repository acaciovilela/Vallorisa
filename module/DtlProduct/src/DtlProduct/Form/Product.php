<?php

namespace DtlProduct\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlProduct\Entity\Product as ProductEntity;

class Product extends Form {

    public function __construct($entityManager, $user) {

        parent::__construct('product');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ProductEntity())
                ->setInputFilter(new InputFilter());
        
        $product = new Fieldset\Product($entityManager, $user);
        $product->setUseAsBaseFieldset(true);
        $this->add($product);
        
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
                'onclick' => "javascript: window.location.href = '/admin/product'",
            )
        ));
    }
}
