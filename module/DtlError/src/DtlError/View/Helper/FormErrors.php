<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DtlError\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class FormErrors extends AbstractHelper {

    /**
     *
     * @var array 
     */
    protected $messages;

    public function __invoke(array $formMessages = []) {
        if (!count($formMessages)) {
            return null;
        }
        
        $htmlOpen = "<div class='alert alert-danger' role='alert'><ul>";
        
        $htmlClose = "</ul></div>";

        $messages = $this->getMessages($formMessages);

        $messagesList = $this->prepareMessages($messages);

        $output = $htmlOpen . $messagesList . $htmlClose;
        
        return $output;
    }

    private function prepareMessages(array $messages = null) {
        $list = '';
        if (is_array($messages)) {
            foreach ($messages as $message) {
                $list .= "<li>" . $message . "</li>";
            }
        }
        return $list;
    }

    private function getMessages(array $data = null) {
        if (!$data) {
            return null;
        }

        if (is_array($data)) {
            foreach ($data as $element) {
                if (is_array($element)) {
                    $this->getMessages($element);
                } else {
                    $this->messages[] = $element;
                }
            }
        }

        return $this->messages;
    }

}
