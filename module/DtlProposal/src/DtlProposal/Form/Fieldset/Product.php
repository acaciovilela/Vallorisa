<?php

namespace DtlProposal\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;

class Product extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {

        parent::__construct('product');

        $this->add(array(
            'name' => 'product',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Produto',
                'empty_option' => 'Selecione o Produto',
                'object_manager' => $entityManager,
                'target_class' => 'DtlProduct\Entity\Product',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findByCategoryType',
                    'params' => array(
                        'category' => 'CAIXA_CATEGORY',
                    )
                )
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'productId',
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
        );
    }

}
