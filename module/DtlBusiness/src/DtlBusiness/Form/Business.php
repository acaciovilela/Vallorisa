<?php

namespace DtlBusiness\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlBusiness\Entity\Business as BusinessEntity;

class Business extends Form {

    public function __construct($entityManager) {

        parent::__construct('business');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new BusinessEntity())
                ->setInputFilter(new InputFilter());
        
        $business = new \DtlBusiness\Form\Fieldset\Business($entityManager);
        $business->setUseAsBaseFieldset(true)
                ->setName('business');
        $this->add($business);
        
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
                'onclick' => "javascript: window.location.href = '/admin/business'",
            )
        ));
    }
}
