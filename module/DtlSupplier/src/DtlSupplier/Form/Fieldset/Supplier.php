<?php

namespace DtlSupplier\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlSupplier\Entity\Supplier as SupplierEntity;

class Supplier extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('supplier');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new SupplierEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $person = new \DtlPerson\Form\Fieldset\Person($entityManager);
        $person->setName('person')
                ->setLabel('Dados Gerais');
        $this->add($person);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'companyId',
        ));
    }
    
    public function getInputFilterSpecification() {
        return array(
            'id' => array(
                'required' => false,
            ),
        );
    }
}
