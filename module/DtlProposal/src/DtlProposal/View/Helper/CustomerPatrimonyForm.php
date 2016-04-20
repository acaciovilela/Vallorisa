<?php

namespace DtlProposal\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlCustomer\Form\Fieldset\CustomerPatrimony;

class CustomerPatrimonyForm extends AbstractHelper {

    public function __invoke(CustomerPatrimony $customerPatrimony) {

        if (!is_object($customerPatrimony) || !($customerPatrimony instanceof CustomerPatrimony)) {
            throw new \Zend\View\Exception\RuntimeException(
                    sprintf('%s is not valid instance of CustomerPatrimony fieldset.'));
        }
        
        return $this->view->render('dtl-proposal/proposal/customerpatrimonyform', array(
            'customerPatrimony' => $customerPatrimony,
        ));
    }
}
