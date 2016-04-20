<?php

namespace DtlBase\View\Helper;

use Zend\View\Helper\AbstractHelper;

class DeleteModal extends AbstractHelper {

    protected $messageOpen = '<div id="delete" class="modal hide fade">';
    
    protected $messageHeader = '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Apagar</h3>
        </div>';

    protected $messageBody = '<div class="modal-body"></div>';
    
    protected $messageFooter = '<div class="modal-footer"></div>';
    
    protected $messageClose = '</div>';
    
    public function __invoke() {

        $output = $this->messageOpen . $this->messageHeader . $this->messageBody . $this->messageFooter . $this->messageClose;

        return $output;
    }
}