<?php

namespace DtlRealty\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlRealty\Entity\Realty as RealtyEntity;

class Realty extends Form {

    public function __construct($entityManager) {

        parent::__construct('realty');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RealtyEntity())
                ->setInputFilter(new InputFilter());
        
        $realty = new Fieldset\DtlRealty($entityManager);
        $realty->setUseAsBaseFieldset(true);
        $this->add($realty);
        
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
                'onclick' => "javascript: window.location.href = '/admin/realty'",
            )
        ));
    }
}
