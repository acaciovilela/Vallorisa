<?php

namespace DtlVehicle\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlVehicle\Entity\Vehicle as VehicleEntity;

class Vehicle extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $id) {
        parent::__construct('vehicle');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new VehicleEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'customer',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'object_manager' => $entityManager,
                'target_class' => 'DtlCustomer\Entity\Customer',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria'=> array('id' => $id),
                    )
                ),
                'label' => 'Cliente'
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
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
                'id' => 'vehicleBrandId',
                'class' => 'form-control input-sm',
                'onchange' => 'javascript: fillSelect(this.value, "/admin/vehicle/vehicle-type/fill", "vehicleTypeId");'
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
                'id' => 'vehicleTypeId',
                'class' => 'form-control input-sm',
                'onchange' => 'javascript: fillSelect(this.value, "/admin/vehicle/vehicle-model/fill", "vehicleModelId");'
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
                'id' => 'vehicleModelId',
                'class' => 'form-control input-sm',
                'onchange' => 'javascript: fillSelect(this.value, "/admin/vehicle/vehicle-version/fill", "vehicleVersionId");'
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
                'id' => 'vehicleVersionId',
                'class' => 'form-control input-sm',
            ),
        ));
        
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'id' => 'vehicleId',
            ),
        ));
        
        $this->add(array(
            'name' => 'year',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Ano',
                'class'         => 'form-control input-sm',
                'id' => 'vehicleYear',
            ),
            'options' => array(
                'label' => 'Ano'
            ),
        ));
        
        $this->add(array(
            'name' => 'yearModel',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'vehicleYearModel', 
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
                'id' => 'vehiclePlate',
                'placeholder'   => 'Placa',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Placa'
            ),
        ));
        
        $this->add(array(
            'name' => 'plateUf',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'vehiclePlateUf',
                'placeholder'   => 'UF',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'UF'
            ),
        ));
        
        $this->add(array(
            'name' => 'color',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'vehicleColor',
                'placeholder'   => 'Cor',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Cor'
            ),
        ));
        
        $this->add(array(
            'name' => 'status',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'vehicleStatus',
                'placeholder'   => 'Situação',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Situação',
                'empty_option' => 'Selecione',
                'value_options' => array(
                    'NOVO' => 'NOVO',
                    'USADO' => 'USADO',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'fuel',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'vehicleFuel',
                'placeholder'   => 'Combustível',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Combustível',
                'empty_option' => 'Selecione',
                'value_options' => array(
                    'ALCOOL' => 'ÁLCOOL',
                    'DIESEL' => 'DIESEL',
                    'FLEX' => 'FLEX',
                    'GASOLINA' => 'GASOLINA',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'frame',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'vehicleFrame',
                'placeholder'   => 'Chassi',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Chassi'
            ),
        ));
        
        $this->add(array(
            'name' => 'frameType',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'vehicleFrameType',
                'placeholder'   => 'Tipo de Chassi',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Tipo de Chassi'
            ),
        ));
        
        $this->add(array(
            'name' => 'renavam',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'vehicleRenavam',
                'placeholder'   => 'Renavam',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Renavam'
            ),
        ));

        $this->add(array(
            'name' => 'licenceUf',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'vehicleLicenceUf',
                'placeholder'   => 'UF',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'UF'
            ),
        ));
        
        $this->add(array(
            'name' => 'ownerType',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'id' => 'vehicleOwnerType',
                'placeholder'   => 'Proprietário',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Proprietário',
                'empty_option' => 'Selecione',
                'value_options' => array(
                    'CONCECIONARIA' => 'CONCECIONÁRIA',
                    'GARAGEM' => 'GARAGEM',
                    'PARTICULAR' => 'PARTICULAR',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'notes',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'id' => 'vehicleNotes',
                'placeholder'   => 'Observações',
                'class'         => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Observações'
            ),
        ));

        $this->add(array(
            'name' => 'value',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'id' => 'vehicleValue',
                'placeholder'   => 'Valor',
                'class'         => 'form-control input-sm currency',
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
