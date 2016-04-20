<?php

namespace DtlBase\View\Helper\Message;

use Zend\View\Helper\AbstractHelper;

class Error extends AbstractHelper {

    public function __invoke($message = null, $title = 'Erro!') {

        $output = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="Close">&times;</button>
                <strong>' . $title . ' </strong> '. $message .'</div>';

        return $output;
    }
}
