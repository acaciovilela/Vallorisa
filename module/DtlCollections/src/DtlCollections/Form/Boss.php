<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DtlCollections\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlCollections\Entity\Boss as BossEntity;

class Boss extends Form {

    public function __construct($entityManager) {

        parent::__construct('boss');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new BossEntity())
                ->setInputFilter(new InputFilter());

        $boss = new Fieldset\Boss($entityManager);
        $boss->setUseAsBaseFieldset(true);
        $this->add($boss);
        
        $this->add(array(
            'type' => 'Submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-primary',
            ),
            'options' => array(
                'label' => 'Salvar'
            ),
        ));
    }

}
