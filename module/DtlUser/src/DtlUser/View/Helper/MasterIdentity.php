<?php

namespace DtlUser\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;

class MasterIdentity extends AbstractHelper {

    /**
     * @var AuthenticationService
     */
    protected $auth;

    public function __invoke() {

        if ($this->getAuth()->hasIdentity()) {

            $identity = $this->auth->getIdentity();

            if ($identity->getParent()) {
                return $identity->getParent();
            }

            return $identity;
        }
        
        return false;
    }
    
    public function getAuth() {
        return $this->auth;
    }

    public function setAuth(AuthenticationService $auth) {
        $this->auth = $auth;
        return $this;
    }
}
