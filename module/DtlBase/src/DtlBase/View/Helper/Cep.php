<?php

namespace DtlBase\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Exception;

class Cep extends AbstractHelper {

    public function __invoke($cep = null) {
        
        $output = null;
        $filter = new \Zend\Filter\Digits();
        
        if ($cep) {
            $cep = $filter->filter($cep);
            if (strlen($cep) !== 8 || (!is_numeric($cep))) {
                return htmlspecialchars('CEP inválido.', ENT_QUOTES, 'UTF-8');
            }

            $prefix         = substr($cep, 0, 2);
            $first_group    = substr($cep, 2, 3);
            $second_group   = substr($cep, 5, 3);
            $output = $prefix . "." . $first_group . "-" . $second_group;
        }
        
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }
}
