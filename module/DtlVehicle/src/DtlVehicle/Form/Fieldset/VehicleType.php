<?php

namespace DtlVehicle\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlVehicle\Entity\VehicleType as VehicleTypeEntity;

class VehicleType extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('vehicleType');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new VehicleTypeEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'vehicle_type_name',
            ),
            'options' => array(
                'empty_option' => 'Selecione um tipo',
                'value_options' => array(
                    'AUTOMÓVEIS' => 'AUTOMÓVEIS',
                    'CAMINHÕES E REBOCADORES' => 'CAMINHÕES E REBOCADORES',
                    'IMPLEMENTOS RODOVIÁRIOS' => 'IMPLEMENTOS RODOVIÁRIOS',
                    'MOTOS' => 'MOTOS',
                    'ÔNIBUS E MICROÔNIBUS' => 'ÔNIBUS E MICROÔNIBUS',
                    'UTILITÁRIOS' => 'UTILITÁRIOS',
                ),
                'label' => 'Tipo de Veículo',
            ),
        ));

        $this->add(array(
            'name' => 'brand',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Marca',
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
                'onchange' => 'javascript: vehicleTypeList(this.value);'
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true,
            ),
            'brand' => array(
                'required' => true,
            )
        );
    }

}
