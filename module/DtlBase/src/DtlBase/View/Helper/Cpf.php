<?php

namespace DtlBase\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Exception;

class Cpf extends AbstractHelper {

    public function __invoke($cpf = null) {
        
        $output = null;
        
        if ($cpf) {
            if (strlen($cpf) !== 11 || (!is_numeric($cpf))) {
                throw new Exception\RuntimeException('O CPF fornecido é inválido.');
            }
            
            $val_1 = substr($cpf, 0, 3);
            $val_2 = substr($cpf, 3, 3);
            $val_3 = substr($cpf, 6, 3);
            $val_4 = substr($cpf, 9, 2);
            $output = $val_1 . "." . $val_2 . "." . $val_3 . "-" . $val_4;
        }
        
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }
}
