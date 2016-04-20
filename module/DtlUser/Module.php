<?php

namespace DtlUser;

use Zend\EventManager\EventInterface;
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

    public function getServiceConfig() {
        return array(
            'initializers' => array(
                'ZfcRbac\Initializer\AuthorizationServiceInitializer',
            ),
            'invokables' => array(
                'dtluser_user_service' => 'DtlUser\Service\User',
            ),
            'factories' => array(
                'zfcuser_update_form' => function ($sm) {
            $options = $sm->get('zfcuser_module_options');
            $form = new \ZfcUser\Form\Register(null, $options);
//                    //$form->setCaptchaElement($sm->get('zfcuser_captcha_element'));
            $form->setInputFilter(new \DtlUser\Form\UpdateFilter($options));
            return $form;
        },
            ),
        );
    }

    public function onBootstrap(EventInterface $e) {
        $target = $e->getTarget();
        $sm = $target->getServiceManager();
        $target->getEventManager()->attach($sm->get('DtlUser\View\Strategy\RedirectStrategy'));

        $eventManager = $e->getApplication()->getEventManager();
        $em = $eventManager->getSharedManager();
        $sm = $e->getApplication()->getServiceManager();

        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'selectLayoutBasedOnRoute'));

        $em->attach('ZfcUser\Form\RegisterFilter', 'init', function($e) {
            $filter = $e->getTarget();
        });

        $em->attach('ZfcUser\Form\Register', 'init', function($e) use ($sm) {
            $form = $e->getTarget();
            if ($form) {
                foreach ($form as $element) {
                    $element->setAttribute('class', 'form-control');
                    $element->setAttribute('autocomplete', 'off');
                }
            }
            $userProfile = new Form\Fieldset\UserProfile($sm->get('doctrine.entitymanager.orm_default'));
            $userProfile->setName('userProfile');
            $form->add($userProfile);
        });

        $zfcServiceEvents = $e->getApplication()->getServiceManager()->get('zfcuser_user_service')->getEventManager();
        $zfcServiceEvents->attach('register', function($e) use ($sm) {
            $form = $e->getParam('form');
            $user = $e->getParam('user');
            $authService = $sm->get('zfcuser_auth_service');
            if (!count($authService->getIdentity())) {
                $user->setParent($authService->getIdentity());
            }
            $user->getProfile()->setLastName($form->get('userProfile')->get('lastName')->getValue());
            $user->getProfile()->setAbout($form->get('userProfile')->get('about')->getValue());
            $user->getProfile()->setNews($form->get('userProfile')->get('news')->getValue());
        });

        // you can even do stuff after it stores           
        $zfcServiceEvents->attach('register.post', function($e) use ($sm) {
            $user = $e->getParam('user');
            // Set roles to new user being 'user' role as default
            $em = $sm->get('doctrine.entitymanager.orm_default');
            $role = $em->getRepository('\DtlUser\Entity\UserRole')->findOneBy(array('name' => 'admin'));
            $user->addRole($role);
        });
    }

    public function selectLayoutBasedOnRoute(MvcEvent $e) {
        $match = $e->getRouteMatch()->getMatchedRouteName();
        if ($match === 'zfcuser/login') {
            $controller = $e->getTarget();
            $controller->layout('layout/login');
            return;
        }
    }

}
