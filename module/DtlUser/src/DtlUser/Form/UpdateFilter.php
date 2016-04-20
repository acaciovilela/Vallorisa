<?php

namespace DtlUser\Form;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use ZfcUser\Options\RegistrationOptionsInterface;

class UpdateFilter extends ProvidesEventsInputFilter {

    /**
     * @var RegistrationOptionsInterface
     */
    protected $options;

    public function __construct(RegistrationOptionsInterface $options) {
        $this->setOptions($options);

        if ($this->getOptions()->getEnableUsername()) {
            $this->add(array(
                'name' => 'username',
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 255,
                        ),
                    ),
                ),
            ));
        }

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress'
                ),
            ),
        ));

        if ($this->getOptions()->getEnableDisplayName()) {
            $this->add(array(
                'name' => 'display_name',
                'required' => true,
                'filters' => array(array('name' => 'StringTrim')),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 3,
                            'max' => 128,
                        ),
                    ),
                ),
            ));
        }

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'filters' => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'passwordVerify',
            'required' => true,
            'filters' => array(array('name' => 'StringTrim')),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password',
                    ),
                ),
            ),
        ));

        $this->getEventManager()->trigger('init', $this);
    }

    /**
     * set options
     *
     * @param RegistrationOptionsInterface $options
     */
    public function setOptions(RegistrationOptionsInterface $options) {
        $this->options = $options;
    }

    /**
     * get options
     *
     * @return RegistrationOptionsInterface
     */
    public function getOptions() {
        return $this->options;
    }

}
