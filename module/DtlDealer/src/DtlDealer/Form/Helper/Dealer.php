<?php

namespace DtlDealer\Form\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Form\Element\Collection;

class Dealer extends AbstractHelper {

    public function __invoke($dealers,  $params = array()) {

        if (!is_object($dealers) || !($dealers instanceof Collection)) {
            throw new \Zend\View\Exception\RuntimeException(
                    sprintf('%s is not valid instance of DtlDealer fieldset.'));
        }
        
        return $this->view->render('dtl-dealer/dealer/form', array(
            'dealers' => $dealers,
            'params' => $params['preProposal'],
        ));
    }
}
