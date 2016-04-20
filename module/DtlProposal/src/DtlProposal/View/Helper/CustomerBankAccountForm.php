<?php

namespace DtlProposal\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlCustomer\Form\Fieldset\CustomerBankAccount;

class CustomerBankAccountForm extends AbstractHelper {

    public function __invoke(CustomerBankAccount $customerBankAccount) {

        if (!is_object($customerBankAccount) || !($customerBankAccount instanceof CustomerBankAccount)) {
            throw new \Zend\View\Exception\RuntimeException(
                    sprintf('%s is not valid instance of CustomerBankAccount fieldset.'));
        }
        
        return $this->view->render('dtl-proposal/proposal/customerbankaccountform', array(
            'customerBankAccount' => $customerBankAccount,
        ));
    }
}
