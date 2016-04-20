<?php

namespace DtlBase\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Exception;

class Date extends AbstractHelper {

    public function __invoke($date = null, $format = null) {
        
        $output = null;

        if (!$format) {
            $format = 'd/m/Y';
        }
        
        if (!is_null($date)) {
            if (!$date instanceof \DateTime) {
                throw new Exception\RuntimeException('A data fornecida é inválida.');
            }

            $output = $date->format($format);
        }
        
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }
}
