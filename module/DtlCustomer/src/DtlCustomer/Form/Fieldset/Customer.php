<?php

namespace DtlCustomer\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlCustomer\Entity\Customer as CustomerEntity;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;

class Customer extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('customer');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new CustomerEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'residenceType',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'placeholder' => 'Tipo de Residência',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Tipo de Residência',
                'empty_option' => 'Selecione o Tipo',
                'value_options' => array(
                    'ALUGADA' => 'ALUGADA',
                    'CEDIDA' => 'CEDIDA',
                    'EMPRESTADA' => 'EMPRESTADA',
                    'FAMILIAR' => 'FAMILIAR',
                    'PRÓPRIA' => 'PRÓPRIA',
                    'OUTRO' => 'OUTRO',
                )
            ),
        ));
        
        $this->add(array(
            'name' => 'residenceTime',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Tempo na Resid.',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Tempo na Resid.',
            ),
        ));
        
        $this->add(array(
            'name' => 'residenceRentValue',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Valor do Aluguel',
                'class' => 'form-control input-sm currency',
            ),
            'options' => array(
                'label' => 'Valor do Aluguel',
            ),
        ));
        
        $this->add(array(
            'name' => 'notes',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'placeholder' => 'Observações',
                'class' => 'form-control input-sm',
                'rows' => 6,
            ),
            'options' => array(
                'label' => 'Observações',
            ),
        ));
        
        $person = new \DtlPerson\Form\Fieldset\Person($entityManager);
        $person->setName('person')
                ->setLabel('Dados Gerais');
        $this->add($person);
    }
    
    public function getInputFilterSpecification() {
        return array(
            'id' => array(
                'required' => false,
            ),
            'residenceType' => array(
                'required' => false,
            ),
            'residenceRentValue' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                )
            ),
        );
    }
}
