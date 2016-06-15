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
        
        $this->add(new People($entityManager));
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification() {
        return array();
    }

}
