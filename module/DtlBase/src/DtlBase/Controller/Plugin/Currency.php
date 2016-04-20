<?php

namespace DtlBase\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Currency extends AbstractPlugin {

    protected $symbol = 'R$';
    
    public function __invoke($currency = 0) {
        
        if ($currency) {
            if (!is_numeric($currency)) {
                throw new Exception\RuntimeException('Valor monetário inválido.');
            }
        } else {
            $currency = 0;
        }
        
        $output = number_format($currency, 2, ',', '.');

        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }
}
