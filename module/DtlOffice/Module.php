<?php

/**
 * @author Acácio Vilela <acaciovilela@gmail.com>
 * @copyright (c) 2012, Acácio Vilela
 * 
 * Module for banks
 */

namespace DtlOffice;

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
}
