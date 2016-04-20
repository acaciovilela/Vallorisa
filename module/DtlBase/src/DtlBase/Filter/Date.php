<?php

namespace DtlBase\Filter;

use Zend\Filter\FilterInterface;

class Date implements FilterInterface {

    public function filter($value) {

        if ($value) {
            $value_array = explode('/', $value);

            $new_date = $value_array[2] . "-" . $value_array[1] . "-" . $value_array[0];
            
            return $new_date;
        }
        
        return null;
    }
}
