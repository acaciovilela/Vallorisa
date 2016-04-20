<?php

namespace DtlProposal\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlCustomer\Form\Fieldset\Customer;

class CustomerForm extends AbstractHelper {

    public function __invoke(Customer $customer, $params = array(), $isLoan = false, $entity = null) {

        if (!is_object($customer) || !($customer instanceof Customer)) {
            throw new \Zend\View\Exception\RuntimeException(
                    sprintf('%s is not valid instance of Customer fieldset.'));
        }
        
        return $this->view->render('dtl-proposal/proposal/customerform', array(
            'customer' => $customer,
            'params' => $params['preProposal'],
            'isLoan' => $isLoan,
            'entity' => $entity
        ));
    }
}
