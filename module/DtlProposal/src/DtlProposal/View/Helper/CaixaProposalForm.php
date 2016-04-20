<?php

namespace DtlProposal\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlProposal\Form\Fieldset\Product;

class CaixaProposalForm extends AbstractHelper {

    public function __invoke(Product $caixaProposal) {

        if (!is_object($caixaProposal) || !($caixaProposal instanceof Product)) {
            throw new \Zend\View\Exception\RuntimeException(
                    sprintf('%s is not valid instance of CaixaProposal fieldset.'));
        }
        
        return $this->view->render('dtl-proposal/caixa-proposal/caixa/caixa', array(
            'caixaProposal' => $caixaProposal
        ));
    }
}
