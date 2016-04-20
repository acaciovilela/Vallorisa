<?php

namespace DtlProposal\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlCustomer\Form\Fieldset\CustomerVehicle;

class CustomerVehicleForm extends AbstractHelper {

    public function __invoke(CustomerVehicle $customerVehicle) {

        if (!is_object($customerVehicle) || !($customerVehicle instanceof CustomerVehicle)) {
            throw new \Zend\View\Exception\RuntimeException(
                    sprintf('%s is not valid instance of CustomerVehicle fieldset.'));
        }
        
        return $this->view->render('dtl-proposal/proposal/customervehicleform', array(
            'customerVehicle' => $customerVehicle,
        ));
    }
}
