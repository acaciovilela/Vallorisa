<?php

namespace DtlBase\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Exception;

class Cnpj extends AbstractHelper {

    public function __invoke($cnpj = null) {

        $output = null;

        if ($cnpj) {
            if (strlen($cnpj) !== 14 || (!is_numeric($cnpj))) {
                throw new Exception\RuntimeException('O CNPJ fornecido é inválido.');
            }

            $val_1 = substr($cnpj, 0, 2);
            $val_2 = substr($cnpj, 2, 3);
            $val_3 = substr($cnpj, 5, 3);
            $val_4 = substr($cnpj, 8, 4);
            $val_5 = substr($cnpj, 12, 2);
            $output = $val_1 . "." . $val_2 . "." . $val_3 . "/" . $val_4 . "-" . $val_5;
        }

        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }

}
