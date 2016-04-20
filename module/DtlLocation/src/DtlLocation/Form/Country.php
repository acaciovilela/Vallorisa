<?php

namespace DtlLocation\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlLocation\Entity\Country as CountryEntity;

class Country extends Form {

    public function __construct($entityManager) {

        parent::__construct('country');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new CountryEntity())
                ->setInputFilter(new InputFilter());
        
        $country = new Fieldset\Country($entityManager);
        $country->setUseAsBaseFieldset(true);
        $this->add($country);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'security'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-primary'
            )
        ));

        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Cancel',
                'class' => 'btn btn-default',
                'onclick' => "javascript: window.location.href = '/admin/location/country'",
            )
        ));
    }
}
