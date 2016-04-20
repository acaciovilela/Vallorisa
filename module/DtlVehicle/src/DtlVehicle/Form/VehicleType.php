<?php

namespace DtlVehicle\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlVehicle\Entity\VehicleType as VehicleTypeEntity;

class VehicleType extends Form {

    public function __construct($entityManager) {

        parent::__construct('vehicleType');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new VehicleTypeEntity())
                ->setInputFilter(new InputFilter());
        
        
        $vehicle_type = new \DtlVehicle\Form\Fieldset\VehicleType($entityManager);
        $vehicle_type->setUseAsBaseFieldset(true);
        $this->add($vehicle_type);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'security'
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Salvar',
                'class' => 'btn btn-primary',
                'onclick' => 'javascript: vehicleTypePost();'
            )
        ));

        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Cancel',
                'class' => 'btn btn-default',
                'onclick' => "javascript: window.location.href = '/admin/vehicle/vehicle-type'",
            )
        ));
    }
}
