<?php

namespace DtlEmployee\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlEmployee\Entity\EmployeeCommission as EmployeeCommissionEntity;

class EmployeeCommission extends ZendFielset implements InputFilterProviderInterface {

    protected $entityManager;

    public function __construct() {
        parent::__construct('commissions');
    }
    
    public function init() {
        
        $this->setHydrator(new DoctrineHydrator($this->getEntityManager()))
                ->setObject(new EmployeeCommissionEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden'
        ));
        
        $this->add(array(
            'name' => 'product',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'empty_option' => 'Selecione',
                'object_manager' => $this->getEntityManager(),
                'target_class' => 'DtlProduct\Entity\Product',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array()
                    )
                ),
                'label' => 'Produto'
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));
        
        $this->add(array(
            'name' => 'fixedCommission',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Comissão Fixa',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'value' => '0,00'
            ),
        ));
        
        $this->add(array(
            'name' => 'variantCommission',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Comissão Variável',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm porcent',
                'value' => '0,00'
            ),
        ));
        
        $this->add(array(
            'name' => 'removeItem',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => array(
                'class' => 'btn btn-sm btn-default remove-commission',
                'onclick' => 'javascript: return removeCommission();',
            ),
            'options' => array(
                'label' => 'Apagar',
            ),
        ));
        $this->get('removeItem')->setValue('Remover');
    }

    public function getInputFilterSpecification() {
        return array(
            'product' => array(
                'required' => false,
            ),
            'fixedCommission' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR')),
                ),
            ),
            'variantCommission' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR')),
                ),
            ),
        );
    }
    
    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }
}
