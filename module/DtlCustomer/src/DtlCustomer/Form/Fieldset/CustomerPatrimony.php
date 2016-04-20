<?php

namespace DtlCustomer\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;

class CustomerPatrimony extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $id) {
        parent::__construct('customerPatrimony');
        
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
        
        $patrimony = new \DtlPatrimony\Form\Fieldset\Patrimony($entityManager);
        $patrimony->setName('patrimony')
                ->setLabel('Patrimônio');
        $this->add($patrimony);
    }

    public function getInputFilterSpecification() {
        return array();
    }

}
