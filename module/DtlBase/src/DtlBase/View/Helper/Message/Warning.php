<?php

namespace DtlBase\View\Helper\Message;

use Zend\View\Helper\AbstractHelper;

class Warning extends AbstractHelper {

    public function __invoke($message = null, $title = 'Atenção!') {

        $output = '<div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="close">&times;</button>
                <strong>' . $title . ' </strong> '. $message .'</div>';

        return $output;
    }

}
