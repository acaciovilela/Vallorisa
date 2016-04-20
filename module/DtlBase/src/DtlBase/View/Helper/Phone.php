<?php

namespace DtlBase\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Exception;

class Phone extends AbstractHelper {

    public function __invoke($phone = null) {

        $output = null;

        if ($phone) {
            
            if (strlen($phone) !== 10 || (!is_numeric($phone))) {
                return $output = NULL;
            }

            $ddd = substr($phone, 0, 2);
            $first_group = substr($phone, 2, 4);
            $second_group = substr($phone, 6, 4);
            $output = "(" . $ddd . ") " . $first_group . "-" . $second_group;
        }

        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }

}
