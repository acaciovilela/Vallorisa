<?php

namespace DtlBase\View\Helper\Message;

use Zend\View\Helper\AbstractHelper;

class Info extends AbstractHelper {

    public function __invoke($message = null, $title = 'Informação!') {

        $output = '<div class="alert alert-info">
                <button type="button" class="close" data-dismiss="close">&times;</button>
                <strong>' . $title . ' </strong> '. $message .'</div>';

        return $output;
    }

}
