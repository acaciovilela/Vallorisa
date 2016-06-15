<?php

namespace DtlCollections\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlCollections\Entity\Master as MasterEntity;

class Master extends Fieldset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('master');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new MasterEntity());
        
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
                'label' => 'Nome do Chefe'
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
                'required' => true,
            )
        );
    }

}
