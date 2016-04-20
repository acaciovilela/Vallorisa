<?php

namespace DtlProduct\Form\Fieldset;

use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlProduct\Entity\Product as ProductEntity;

class Product extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $user) {
        parent::__construct('product');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ProductEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Nome do Produto',
                'class'         => 'form-control input-sm',
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Nome do Produto'
            ),
        ));
        
        $this->add(array(
            'name' => 'variantCommission',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'R$ 0,00',
                'class' => 'form-control input-sm currency'
            ),
            'options' => array(
                'label' => 'Comissão Variável',
            )
        ));
        
        $this->add(array(
            'name' => 'fixedCommission',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'R$ 0,00',
                'class' => 'form-control input-sm currency'
            ),
            'options' => array(
                'label' => 'Comissão Fixa',
            )
        ));
        
        $this->add(array(
            'name' => 'isActive',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Produto ativo.'
            ),
        ));
        
        $this->add(array(
            'name' => 'category',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlProduct\Entity\Category',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria'=> array('user' => $user),
                    )
                ),
                'label' => 'Categoria'
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'onchange' => 'javascript: productList(this.value);',
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StringToUpper', 'options' => array(
                        'encoding' => 'UTF-8'
                    )),
                ),
            ),
            'variantCommission' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Porcent(),
                ),
            ),
            'fixedCommission' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Currency(),
                ),
            ),
            'isActive' => array(
                'required' => false,
            ),
            'category' => array(
                'required' => true,
            ),
        );
    }
}
