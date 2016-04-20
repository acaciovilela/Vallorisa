<?php

namespace DtlProposal\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlRealty\Form\Fieldset\Realty;

class RealtyProposalForm extends AbstractHelper {

    public function __invoke(Realty $realtyProposal) {

        if (!is_object($realtyProposal) || !($realtyProposal instanceof Realty)) {
            throw new \Zend\View\Exception\RuntimeException(
                    sprintf('%s is not valid instance of RealtyProposal fieldset.'));
        }
        
        return $this->view->render('dtl-proposal/realty-proposal/realty/realty', array(
            'realtyProposal' => $realtyProposal
        ));
    }
}
