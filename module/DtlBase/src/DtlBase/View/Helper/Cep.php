<?php

namespace DtlBase\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Exception;

class Cep extends AbstractHelper {

    public function __invoke($cep = null) {
        
        $output = null;
        
        if ($cep) {
            if (strlen($cep) !== 8 || (!is_numeric($cep))) {
                throw new Exception\RuntimeException('CEP inválido.');
            }

            $prefix         = substr($cep, 0, 2);
            $first_group    = substr($cep, 2, 3);
            $second_group   = substr($cep, 5, 3);
            $output = $prefix . "." . $first_group . "-" . $second_group;
        }
        
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }
}
