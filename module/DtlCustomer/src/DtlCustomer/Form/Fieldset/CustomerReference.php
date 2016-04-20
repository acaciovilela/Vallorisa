<?php

namespace DtlCustomer\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;

class CustomerReference extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $id) {
        parent::__construct('customerReference');
        
        $this->add(array(
            'name' => 'customer',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'object_manager' => $entityManager,
                'target_class' => 'DtlCustomer\Entity\Customer',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria'=> array('id' => $id),
                    )
                ),
                'label' => 'Cliente'
            ),
            'attributes' => array(
                'id' => 'customer_id',
                'class' => 'form-control input-sm',
            )
        ));
        
        $reference = new \DtlReference\Form\Fieldset\Reference($entityManager);
        $reference->setName('reference')
                ->setLabel('Referência');
        $this->add($reference);
    }

    public function getInputFilterSpecification() {
        return array();
    }

}
