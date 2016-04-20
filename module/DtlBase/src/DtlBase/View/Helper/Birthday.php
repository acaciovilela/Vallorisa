<?php

namespace DtlBase\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Birthday extends AbstractHelper {

    public function __invoke($day = null, $month = null, $year = null) {
        
        $output = null;
        
        if (!empty($day) || !empty($month) || !empty($year)) {
            $output = $day . "/" . $month . "/" . $year;
        }
        
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }
}
