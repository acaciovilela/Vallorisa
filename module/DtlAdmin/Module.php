<?php

namespace DtlAdmin;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature;
use Zend\EventManager\EventInterface;
use Zend\Mvc\Router\RouteMatch;

class Module implements Feature\AutoloaderProviderInterface, Feature\ConfigProviderInterface, Feature\ServiceProviderInterface, Feature\BootstrapListenerInterface {

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

    /**
     * @{inheritdoc}
     */
    public function getServiceConfig() {
        return array();
    }

    /**
     * @{inheritdoc}
     */
    public function onBootstrap(EventInterface $e) {
        $app = $e->getParam('application');
        $em = $app->getEventManager();

        $t = $e->getTarget();
        
        $t->getEventManager()->attach(
                $t->getServiceManager()->get('ZfcRbac\View\Strategy\RedirectStrategy')
        );

        $em->attach(MvcEvent::EVENT_DISPATCH, array($this, 'selectLayoutBasedOnRoute'));
    }

    /**
     * Select the admin layout based on route name
     *
     * @param  MvcEvent $e
     * @return void
     */
    public function selectLayoutBasedOnRoute(MvcEvent $e) {
        $app = $e->getParam('application');
        $sm = $app->getServiceManager();
        $config = $sm->get('config');

        if (false === $config['dtladmin']['use_admin_layout']) {
            return;
        }

        if ($app->getRequest()->isXmlHttpRequest()) {
            $view = $app->getMvcEvent()->getViewModel();
            $controller = $e->getTarget();
            $controller->layout('layout/blank');
            $view->setTerminal(true);
        } else {
            $match = $e->getRouteMatch();
            $controller = $e->getTarget();
            if (!$match instanceof RouteMatch || 0 !== strpos($match->getMatchedRouteName(), 'dtladmin') || $controller->getEvent()->getResult()->terminate()) {
                return;
            }
            $layout = $config['dtladmin']['admin_layout_template'];
            $controller->layout($layout);
        }
    }

}
