<?php

namespace DtlBase\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Exception;

class Porcent extends AbstractHelper {

    protected $symbol = '%';

    public function __invoke($value = null) {

        $output = 0;

        if ($value) {
            if (!is_numeric($value)) {
                throw new Exception\RuntimeException('Valor de porcentagem inválido.');
            }
        } else {
            $value = 0;
        }
        
        $output = number_format($value, 2, ',', '.') . ' '. $this->symbol;

        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }
}
