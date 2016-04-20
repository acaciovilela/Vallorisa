<?php

namespace DtlBase\Form\View\Helper;

use Zend\Form\View\Helper\FormElementErrors;

class FormElementError extends FormElementErrors {

    protected $messageOpenFormat = '<div%s class="alert alert-danger" role="alert"><div>';
    protected $messageSeparatorString = '</div><div>';
    protected $messageCloseString = '</div></div>';

    public function getMessageOpenFormat() {
        return $this->messageOpenFormat;
    }

    public function getMessageSeparatorString() {
        return $this->messageSeparatorString;
    }

    public function getMessageCloseString() {
        return $this->messageCloseString;
    }

    public function setMessageOpenFormat($messageOpenFormat) {
        $this->messageOpenFormat = $messageOpenFormat;
        return $this;
    }

    public function setMessageSeparatorString($messageSeparatorString) {
        $this->messageSeparatorString = $messageSeparatorString;
        return $this;
    }

    public function setMessageCloseString($messageCloseString) {
        $this->messageCloseString = $messageCloseString;
        return $this;
    }
}
