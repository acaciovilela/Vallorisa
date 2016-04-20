<?php

namespace DtlVehicle\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlVehicle\Entity\VehicleBrand as VehicleBrandEntity;

class VehicleBrand extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('vehicleBrand');

        

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new VehicleBrandEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Marca'
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true
            )
        );
    }
}
