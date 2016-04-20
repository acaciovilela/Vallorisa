<?php

namespace DtlLocation\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlLocation\Entity\State as StateEntity;

class State extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('state');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new StateEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Estado',
                'class'         => 'form-control input-sm',
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Estado'
            )
        ));
        
        $this->add(array(
            'name' => 'code',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Sigla',
                'class'         => 'form-control input-sm',
                'required'      => 'required',
                'maxlength'     => 2
            ),
            'options' => array(
                'label' => 'Sigla'
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true,
            ),
            'code' => array(
                'required' => true,
                'filters' => array(
                    new \Zend\Filter\StringTrim(),
                ),
            ),
        );
    }
}
