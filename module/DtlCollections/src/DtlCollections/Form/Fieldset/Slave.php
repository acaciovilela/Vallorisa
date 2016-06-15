<?php

namespace DtlCollections\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlCollections\Entity\Slave;

class Slave extends Fieldset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('slave');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new Slave());
        
        $this->add(array(
            'type' => 'Hidden',
            'name' => 'id'
        ));
        
        $this->add(array(
            'type' => 'Text',
            'name' => 'name', 
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Nome do Escravo',
            )
        ));
        
        $this->add(array(
            'type' => 'Text',
            'name' => 'color', 
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Cor',
            )
        ));
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => false,
            ),
            'color' => array(
                'required' => false,
            ),
        );
    }

}
