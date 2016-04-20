<?php

namespace DtlVehicle\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlVehicle\Entity\VehicleModel as VehicleModelEntity;

class VehicleModel extends Form {

    public function __construct($entityManager) {

        parent::__construct('vehicleModel');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new VehicleModelEntity())
                ->setInputFilter(new InputFilter());
        
        
        $vehicle_model = new \DtlVehicle\Form\Fieldset\VehicleModel($entityManager);
        $vehicle_model->setUseAsBaseFieldset(true);
        $this->add($vehicle_model);
        
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
                'onclick' => 'javascript: vehicleModelPost();'
            )
        ));

        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Cancel',
                'class' => 'btn btn-default',
                'onclick' => "javascript: window.location.href = '/admin/vehicle/vehicle-model'",
            )
        ));
    }
}
