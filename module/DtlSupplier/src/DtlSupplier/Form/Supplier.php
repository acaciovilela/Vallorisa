<?php

namespace DtlSupplier\Form;

use DtlSupplier\Entity\Supplier as SupplierEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form;

class Supplier extends Form {

    public function __construct($entityManager) {

        parent::__construct('supplier');
        
        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new SupplierEntity())
                ->setInputFilter(new InputFilter());

        $supplier = new Fieldset\Supplier($entityManager);
        $supplier->setUseAsBaseFieldset(true);
        $this->add($supplier);

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
                'onclick' => "javascript: window.location.href = '/admin/supplier'",
            )
        ));
    }
}
