<?php

namespace DtlPerson\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use DtlPerson\Entity\Address as AddressEntity;
use Zend\Form\Fieldset;

class Address extends Fieldset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('address');
        
        $this->setLabel('Dados de Endereço');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new AddressEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Endereço',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Endereço'
            ),
        ));

        $this->add(array(
            'name' => 'number',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Nº',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Nº'
            ),
        ));

        $this->add(array(
            'name' => 'complement',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Complemento',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Complemento'
            ),
        ));

        $this->add(array(
            'name' => 'quarter',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Bairro',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Bairro'
            ),
        ));

        $this->add(array(
            'name' => 'postalCode',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'CEP',
                'class' => 'form-control input-sm  cep',
                'onblur' => 'javascript: fetchAddressByCep(this.value);'
            ),
            'options' => array(
                'label' => 'CEP'
            ),
        ));

        $this->add(array(
            'name' => 'cityName',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Cidade',
                'class' => 'form-control input-sm  city',
                'id' => 'cityName',
            ),
            'options' => array(
                'label' => 'Cidade'
            ),
        ));
        
        $this->add(array(
            'name' => 'stateName',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Estado',
                'class' => 'form-control input-sm  state',
                'id' => 'stateName',
            ),
            'options' => array(
                'label' => 'Estado'
            ),
        ));
        
        $this->add(array(
            'name' => 'countryName',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'País',
                'class' => 'form-control input-sm  country',
                'id' => 'countryName',
            ),
            'options' => array(
                'label' => 'País'
            ),
        ));
        
        $this->add(array(
            'name' => 'city',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Cidade',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlLocation\Entity\City',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));
        
        $this->add(array(
            'name' => 'state',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Estado',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlLocation\Entity\State',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));
        
        $this->add(array(
            'name' => 'country',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'País',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlLocation\Entity\Country',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'postalCode' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'Digits')
                )
            ),
            'city' => array(
                'required' => false,
            ),
            'state' => array(
                'required' => false,
            ),
            'country' => array(
                'required' => false,
            ),
        );
    }
}
