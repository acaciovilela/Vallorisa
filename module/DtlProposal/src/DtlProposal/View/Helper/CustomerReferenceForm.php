<?php

namespace DtlProposal\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlCustomer\Form\Fieldset\CustomerReference;

class CustomerReferenceForm extends AbstractHelper {

    public function __invoke(CustomerReference $customerReference) {

        if (!is_object($customerReference) || !($customerReference instanceof CustomerReference)) {
            throw new \Zend\View\Exception\RuntimeException(
                    sprintf('%s is not valid instance of CustomerReference fieldset.'));
        }
        
        return $this->view->render('dtl-proposal/proposal/customerreferenceform', array(
            'customerReference' => $customerReference
        ));
    }

}
