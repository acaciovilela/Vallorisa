<?php

namespace DtlRealty\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlRealty\Entity\RealtyType as RealtyTypeEntity;

class RealtyType extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('realtyType');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RealtyTypeEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'placeholder' => 'Tipo do Imóvel',
            ),
            'options' => array(
                'label' => 'Tipo do Imóvel'
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true,
            ),
        );
    }
}
