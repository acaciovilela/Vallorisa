<?php

namespace DtlPerson\Form\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlPerson\Form\Fieldset\Legal;

class LegalForm extends AbstractHelper {

    public function __invoke(Legal $fieldset) {

        if (!is_object($fieldset) || !($fieldset instanceof Legal)) {
            throw new \Zend\View\Exception\RuntimeException(
            sprintf('%s is not valid instance of Legal fieldset.'));
        }

        return $this->view->render('dtl-person/legal', array('legal' => $fieldset));
    }

}
