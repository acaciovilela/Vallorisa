<?php

namespace DtlBase\View\Helper\Message;

use Zend\View\Helper\AbstractHelper;

class Success extends AbstractHelper {

    public function __invoke($message = null, $title = 'Sucesso!') {

        $output = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="close">&times;</button>
                <strong>' . $title . ' </strong> '. $message .'</div>';

        return $output;
    }

}
