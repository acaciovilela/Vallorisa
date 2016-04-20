<?php

namespace DtlVehicle\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlVehicle\Entity\VehicleVersion as VehicleVersionEntity;

class VehicleVersion extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('vehicleVersion');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new VehicleVersionEntity());

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
                'id' => 'vehicle_brand_id',
                'class' => 'form-control input-sm',
                'required' => 'required',
                'onchange' => 'javascript: fillSelect(this.value, "/admin/vehicle/vehicle-type/fill", "vehicle_type_id");'
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
                'id' => 'vehicle_type_id',
                'class' => 'form-control input-sm',
                'required' => 'required',
                'onchange' => 'javascript: fillSelect(this.value, "/admin/vehicle/vehicle-model/fill", "vehicle_model_id");'
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
                'id' => 'vehicle_model_id',
                'class' => 'form-control input-sm',
                'required' => 'required',
                'onchange' => 'javascript: vehicleVersionList(this.value);'
            ),
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'vehicle_version_name',
            ),
            'options' => array(
                'label' => 'Versão do Veículo'
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'brand' => array(
                'required' => true,
            ),
            'type' => array(
                'required' => true,
            ),
            'model' => array(
                'required' => true,
            ),
            'name' => array(
                'required' => true,
            ),
        );
    }

}
