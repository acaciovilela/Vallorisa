<?php

namespace DtlAdmin\Navigation\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

/**
 * @package    DtlAdmin
 * @subpackage Navigation\Service
 */
class NavigationFactory extends DefaultNavigationFactory {

    /**
     * @{inheritdoc}
     */
    protected function getName() {
        return 'dtladmin';
    }

}
