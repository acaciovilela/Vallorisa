<?php

namespace DtlProduct\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlProduct\Entity\Category as CategoryEntity;

class Category extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('category');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new CategoryEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
       
        $this->add(array(
            'name' => 'parent',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Nome da Categoria',
                'class'         => 'form-control input-sm',
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Nome da Categoria'
            ),
        ));
        
        $this->add(array(
            'name' => 'type',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'placeholder'   => 'Tipo',
                'class'         => 'form-control input-sm',
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Categoria Pai',
                'empty_option' => 'Selecione',
                'value_options' => array(
                    'VEHICLE_CATEGORY' => 'VEÍCULO',
                    'REALTY_CATEGORY' => 'IMÓVEL',
                    'LOAN_CATEGORY' => 'CONSIGNADO',
                    'CAIXA_CATEGORY' => 'CAIXA',
                ),
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true,
            ),
            'type' => array(
                'required' => true,
            ),
        );
    }
}
