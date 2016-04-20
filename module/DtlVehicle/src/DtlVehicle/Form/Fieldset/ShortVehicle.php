<?php

namespace DtlVehicle\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;

class ShortVehicle extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('vehicle');
        
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'brand',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Marca do Veículo',
                'object_manager' => $entityManager,
                'target_class' => 'DtlVehicle\Entity\VehicleBrand',
                'property' => 'name',
                'empty_option' => 'Marca',
                'is_method' => false,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC')
                    )
                )
            ),
            'attributes' => array(
                'id' => 'customerVehicleBrandId',
                'class' => 'form-control input-sm',
                'onchange' => 'javascript: fillSelect(this.value, "/admin/vehicle/vehicle-type/fill", "customerVehicleTypeId");'
            )
        ));
        
        $this->add(array(
            'name' => 'type',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Tipo do Veículo',
                'object_manager' => $entityManager,
                'target_class' => 'DtlVehicle\Entity\VehicleType',
                'property' => 'name',
                'empty_option' => 'Selecione',
            ),
            'attributes' => array(
                'id' => 'customerVehicleTypeId',
                'class' => 'form-control input-sm',
                'onchange' => 'javascript: fillSelect(this.value, "/admin/vehicle/vehicle-model/fill", "customerVehicleModelId");'
            ),
        ));
        
        $this->add(array(
            'name' => 'model',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Modelo de Veículo',
                'object_manager' => $entityManager,
                'target_class' => 'DtlVehicle\Entity\VehicleModel',
                'property' => 'name',
                'empty_option' => 'Selecione',
            ),
            'attributes' => array(
                'id' => 'customerVehicleModelId',
                'class' => 'form-control input-sm',
                'onchange' => 'javascript: fillSelect(this.value, "/admin/vehicle/vehicle-version/fill", "customerVehicleVersionId");'
            ),
        ));
        
        $this->add(array(
            'name' => 'version',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Versão do Veículo',
                'object_manager' => $entityManager,
                'target_class' => 'DtlVehicle\Entity\VehicleVersion',
                'property' => 'name',
                'empty_option' => 'Selecione',
            ),
            'attributes' => array(
                'id' => 'customerVehicleVersionId',
                'class' => 'form-control input-sm',
            ),
        ));
        
        $this->add(array(
            'name' => 'year',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'customerVehicleYear',
                'placeholder'   => 'Ano',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Ano',
            ),
        ));
        
        $this->add(array(
            'name' => 'yearModel',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'customerVehicleYearModel',
                'placeholder'   => 'Modelo',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Modelo'
            ),
        ));
        
        $this->add(array(
            'name' => 'plate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'customerVehiclePlate',
                'placeholder'   => 'Placa',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Placa'
            ),
        ));
        
        $this->add(array(
            'name' => 'color',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'customerVehicleColor',
                'placeholder'   => 'Cor',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Cor'
            ),
        ));
        
        $this->add(array(
            'name' => 'value',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'customerVehicleValue',
                'placeholder'   => 'Valor',
                'class'         => 'form-control input-sm currency',
                'value' => 0.00,
            ),
            'options' => array(
                'label' => 'Valor'
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array();
    }
}
