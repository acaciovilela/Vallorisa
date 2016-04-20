<?php

namespace DtlVehicle\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlVehicle\Entity\VehicleBrand as VehicleBrandEntity;

class VehicleBrand extends Form {

    public function __construct($entityManager) {

        parent::__construct('vehicleBrand');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new VehicleBrandEntity())
                ->setInputFilter(new InputFilter());


        $vehicle_brand = new \DtlVehicle\Form\Fieldset\VehicleBrand($entityManager);
        $vehicle_brand->setUseAsBaseFieldset(true);
        $this->add($vehicle_brand);

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'security'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-primary'
            )
        ));

        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Cancel',
                'class' => 'btn btn-default',
                'onclick' => "javascript: window.location.href = '/admin/vehicle/vehicle-brand'",
            )
        ));
    }

}
