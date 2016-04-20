<?php

namespace DtlBase\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Gender extends AbstractHelper {

    public function __invoke($gender = null) {
        
        $output = null;
        switch ($gender) {
            case '1':
                $output = 'MASCULINO';
                break;
            case '0':
                $output = 'FEMININO';
                break;
            default:
                $output = '';
        }

        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }
}
