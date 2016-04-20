<?php

namespace DtlBase\Filter;

use Zend\Filter\FilterInterface;

class Currency implements FilterInterface {

    public function filter($value) {

        $valueFiltered = 0;
        
        if (!empty($value)) {
            $symbolOff      = str_replace('R$ ', '', $value);
            $dotoff         = str_replace('.', '', $symbolOff);
            $valueFiltered  = str_replace(',', '.', $dotoff);
        }
        
        return $valueFiltered;
    }
}
