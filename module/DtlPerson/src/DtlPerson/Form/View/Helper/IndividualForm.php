<?php

namespace DtlPerson\Form\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlPerson\Form\Fieldset\Individual;

class IndividualForm extends AbstractHelper {

    public function __invoke(Individual $fieldset) {

        if (!is_object($fieldset) || !($fieldset instanceof Individual)) {
            throw new \Zend\View\Exception\RuntimeException(
            sprintf('%s is not valid instance of Individual fieldset.'));
        }

        return $this->view->render('dtl-person/individual', array('individual' => $fieldset));
    }

}
