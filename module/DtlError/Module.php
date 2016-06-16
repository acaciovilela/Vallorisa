<?php

namespace DtlError;

use Zend\Mvc\MvcEvent;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function onBootstrap(MvcEvent $e) {
        $application = $e->getApplication();
        $em = $application->getEventManager();
        
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER_ERROR, array($this, 'handleError'));
    }

    public function handleError(MvcEvent $e) {
    }

}
