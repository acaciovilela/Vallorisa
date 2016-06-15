<?php

namespace DtlPerson\Form\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlPerson\Form\Fieldset\Person;

class PersonForm extends AbstractHelper {

    public function __invoke(Person $fieldset) {

        if (!is_object($fieldset) || !($fieldset instanceof Person)) {
            throw new \Zend\View\Exception\RuntimeException(
            sprintf('%s is not valid instance of Person fieldset.'));
        }

        return $this->view->render('dtl-person/person', array('person' => $fieldset));
    }

}
