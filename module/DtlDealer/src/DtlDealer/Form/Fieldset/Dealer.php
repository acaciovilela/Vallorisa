<?php

namespace DtlDealer\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlDealer\Entity\Dealer as DealerEntity;

class Dealer extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {

        parent::__construct('dealer');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new DealerEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $person = new \DtlPerson\Form\Fieldset\Person($entityManager);
        $person->setName('person')
                ->setLabel('Dados Gerais');
        $this->add($person);
    }

    public function getInputFilterSpecification() {
        return array();
    }

}
