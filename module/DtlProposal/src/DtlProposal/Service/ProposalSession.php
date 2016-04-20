<?php

namespace DtlProposal\Service;

use Zend\Session\Container;

class ProposalSession extends Container implements ProposalSessionInterface {

    public $proposalSession;

    public function __construct() {
        return $this->getProposalSession();
    }

    public function getProposalSession() {
        if ($this->proposalSession === null) {
            parent::__construct('ProposalSession');
            $this->proposalSession = $this;
        }
        return $this->proposalSession;
    }
}
