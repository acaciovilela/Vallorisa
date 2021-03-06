<?php

namespace DtlProposal\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlVehicle\Form\Fieldset\Vehicle;

class VehicleProposalForm extends AbstractHelper {

    public function __invoke(Vehicle $vehicle) {

        if (!is_object($vehicle) || !($vehicle instanceof Vehicle)) {
            throw new \Zend\View\Exception\RuntimeException(
                    sprintf('%s is not valid instance of VehicleProposal fieldset.'));
        }
        
        return $this->view->render('dtl-proposal/vehicle-proposal/vehicle/vehicle', array(
            'vehicle' => $vehicle
        ));
    }
}
