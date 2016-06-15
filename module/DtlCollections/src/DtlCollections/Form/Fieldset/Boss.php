<?php

namespace DtlCollections\Form\Fieldset;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlCollections\Entity\Boss as BossEntity;

class Boss extends Fieldset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('boss');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new BossEntity());

        $this->add(array(
            'type' => 'Hidden',
            'name' => 'id'
        ));
        
        $master = new Master($entityManager);
        $master->setUseAsBaseFieldset(true);
        $this->add($master);

        $slaves = new \Zend\Form\Element\Collection();
        $slaves->setName('slaves')
                ->setCount(2)
                ->setTargetElement(new Slave($entityManager))
                ->shouldCreateTemplate(true);
        $this->add($slaves);
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
