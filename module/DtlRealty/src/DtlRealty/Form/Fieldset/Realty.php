<?php

namespace DtlRealty\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlRealty\Entity\Realty as RealtyEntity;

class Realty extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('realty');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RealtyEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'type',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Tipo do Imóvel',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlRealty\Entity\RealtyType',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'isActive' => true,
                        ),
                        'orderBy' => array('name' => 'ASC')
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
            )
        ));
        
        $this->add(array(
            'name' => 'value',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'placeholder' => 'Valor do Imóvel',
                'id' => 'realtyValue',
                'onblur' => 'javascript: setRealtyProposalTotalValue(this.value);'
            ),
            'options' => array(
                'label' => 'Valor do Imóvel'
            ),
        ));
        
        $this->add(array(
            'name' => 'code',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'placeholder' => '',
            ),
            'options' => array(
                'label' => 'Matrícula do Imóvel'
            ),
        ));
        
        $this->add(array(
            'name' => 'notes',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'placeholder' => 'Observações',
                'id' => 'realtyNotes',
            ),
            'options' => array(
                'label' => 'Observações'
            ),
        ));
        
        $realtyFeature = new RealtyFeature($entityManager);
        $realtyFeature->setName('realtyFeature');
        $this->add($realtyFeature);
        
        $address = new \DtlPerson\Form\Fieldset\Address($entityManager);
        $address->setName('address');
        $this->add($address);
    }

    public function getInputFilterSpecification() {
        return array(
            'value' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
        );
    }
}
