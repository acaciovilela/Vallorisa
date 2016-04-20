<?php

namespace DtlUser\View\Strategy;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;
use ZfcRbac\View\Strategy\AbstractStrategy;

class RedirectStrategy extends AbstractStrategy {

    /**
     * @var AuthenticationService
     */
    protected $authenticationService;

    /**
     * @param AuthenticationService   $authenticationService
     */
    public function __construct(AuthenticationService $authenticationService) {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @param  MvcEvent $event
     * @return void
     */
    public function onError(MvcEvent $event) {
        $app = $event->getApplication();
        $serviceManager = $app->getServiceManager();
        if ($this->authenticationService->hasIdentity()) {
            $serviceManager->get('ZfcRbac\View\Strategy\UnauthorizedStrategy')->onError($event);
        } else {
            $serviceManager->get('ZfcRbac\View\Strategy\RedirectStrategy')->onError($event);
        }
    }

}
