<?php

namespace DtlShopman\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;

class ShopmanProduct extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('shopmanProduct');

        $this->setHydrator(new DoctrineHydrator($entityManager));

        $this->add(array(
            'name' => 'isLoan',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'shopman',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'id' => 'shopmanId'
            ),
        ));
        
        $this->add(array(
            'name' => 'product',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlProduct\Entity\Product',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'isActive' => true,
                        )
                    )
                ),
                'label' => 'Produtos'
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'productId'
            )
        ));
    }
    
    public function getInputFilterSpecification() {
        return array(
            
        );
    }
}
