<?php

namespace DtlBase\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Exception;

class Currency extends AbstractHelper {

    protected $symbol = 'R$';

    public function __invoke($currency = null, $symbol = true) {

        $output = 0;

        if ($currency) {
            if (!is_numeric($currency)) {
                throw new Exception\RuntimeException('Valor monetário inválido.');
            }
        } else {
            $currency = 0;
        }
        
        if ($symbol) {
            $output = $this->symbol . ' ' . number_format($currency, 2, ',', '.');
        } else {
            $output = number_format($currency, 2, ',', '.');
        }
        
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }

}
