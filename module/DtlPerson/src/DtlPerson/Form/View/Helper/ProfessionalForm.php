<?php

namespace DtlPerson\Form\View\Helper;

use Zend\View\Helper\AbstractHelper;
use DtlPerson\Form\Fieldset\Professional;

class ProfessionalForm extends AbstractHelper {

    public function __invoke(Professional $professional) {

        if (!is_object($professional) || !($professional instanceof Professional)) {
            throw new \Zend\View\Exception\RuntimeException(
            sprintf('%s is not valid instance of Professional fieldset.'));
        }

        return $this->view->render('dtl-person/professional', array(
                    'professional' => $professional
        ));
    }

}
