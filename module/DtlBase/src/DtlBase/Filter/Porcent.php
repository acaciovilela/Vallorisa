<?php

namespace DtlBase\Filter;

use Zend\Filter\FilterInterface;

class Porcent implements FilterInterface {

    public function filter($value) {

        $valueFiltered = null;
        
        if (!empty($value)) {
            $dotoff = str_replace('.', '', $value);
            $valueFiltered = str_replace(',', '.', $dotoff);
        }
        
        return $valueFiltered;
    }
}
