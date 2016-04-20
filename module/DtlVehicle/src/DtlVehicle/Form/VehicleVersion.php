<?php

namespace DtlVehicle\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlVehicle\Entity\VehicleVersion as VehicleVersionEntity;

class VehicleVersion extends Form {

    public function __construct($entityManager) {

        parent::__construct('vehicleVersion');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new VehicleVersionEntity())
                ->setInputFilter(new InputFilter());
        
        
        $vehicle_version = new \DtlVehicle\Form\Fieldset\VehicleVersion($entityManager);
        $vehicle_version->setUseAsBaseFieldset(true);
        $this->add($vehicle_version);
        
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
                'onclick' => 'javascript: vehicleVersionPost();'
            )
        ));

        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Cancel',
                'class' => 'btn btn-default',
                'onclick' => "javascript: window.location.href = '/admin/vehicle/vehicle-version'",
            )
        ));
    }
}
