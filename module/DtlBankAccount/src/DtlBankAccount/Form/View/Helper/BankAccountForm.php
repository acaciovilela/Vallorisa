<?php

namespace DtlBankAccount\Form\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlBankAccount\Form\Fieldset\DtlBankAccount;

class BankAccountForm extends AbstractHelper {

    public function __invoke(DtlBankAccount $bankAccount) {

        if (!is_object($bankAccount) || !($bankAccount instanceof DtlBankAccount)) {
            throw new \Zend\View\Exception\RuntimeException(
            sprintf('%s is not valid instance of DtlBankAccount fieldset.'));
        }

        return $this->view->render('dtl-bank-account/bank-account', array(
                    'bankAccount' => $bankAccount
        ));
    }

}
