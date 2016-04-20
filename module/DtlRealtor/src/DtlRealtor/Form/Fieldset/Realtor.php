<?php

namespace DtlRealtor\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlRealtor\Entity\Realtor as RealtorEntity;

class Realtor extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('realtor');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RealtorEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $person = new \DtlPerson\Form\Fieldset\Person($entityManager);
        $person->setName('person')
                ->setLabel('Dados Gerais');
        $this->add($person);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'commission',
            'options' => array(
                'label' => 'Comissão',
            ),
            'attributes' => array(
                'placeholder' => 'Comissão',
                'class' => 'form-control input-sm porcent'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'fixedCommission',
            'options' => array(
                'label' => 'Comissão Fixa',
            ),
            'attributes' => array(
                'placeholder' => 'Comissão Fixa',
                'class' => 'form-control input-sm currency'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'bonus',
            'options' => array(
                'label' => 'Bônus',
            ),
            'attributes' => array(
                'placeholder' => 'Bônus',
                'class' => 'form-control input-sm currency'
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'company',
        ));
    }
    
    public function getInputFilterSpecification() {
        return array(
            'id' => array(
                'required' => false,
            ),
            'commission' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'fixedCommission' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'bonus' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
        );
    }
}
