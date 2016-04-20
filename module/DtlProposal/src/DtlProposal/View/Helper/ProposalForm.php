<?php

namespace DtlProposal\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlProposal\Form\Fieldset\Proposal;

class ProposalForm extends AbstractHelper {

    public function __invoke(Proposal $proposal) {

        if (!is_object($proposal) || !($proposal instanceof Proposal)) {
            throw new \Zend\View\Exception\RuntimeException(
                    sprintf('%s is not valid instance of Proposal fieldset.'));
        }
        
        return $this->view->render('dtl-proposal/proposal/proposalform', array(
            'proposal' => $proposal
        ));
    }
}
