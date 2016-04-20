<?php

namespace DtlProposal\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlProposal\Entity\VehicleProposal as VehicleProposalEntity;

class VehicleProposal extends Form {

    public function __construct($entityManager, $userId) {

        parent::__construct('vehicleProposal');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new VehicleProposalEntity())
                ->setInputFilter(new InputFilter());

        $vehicleProposal = new Fieldset\VehicleProposal($entityManager, $userId);
        $vehicleProposal->setUseAsBaseFieldset(true);
        $this->add($vehicleProposal);
        
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
                'onclick' => 'javascript: window.location.href = "/admin/proposal/vehicle-proposal";'
            )
        ));
    }
}
