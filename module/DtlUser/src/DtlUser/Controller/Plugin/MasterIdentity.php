<?php

namespace DtlUser\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Authentication\AuthenticationService;

/**
 * 
 */
class MasterIdentity extends AbstractPlugin {

    /**
     * @var AuthenticationService
     */
    protected $auth;

    /**
     * 
     * @return AuthenticationService
     */
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
