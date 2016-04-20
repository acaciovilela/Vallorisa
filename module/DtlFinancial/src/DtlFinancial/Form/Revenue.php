<?php

namespace DtlFinancial\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlFinancial\Entity\Revenue as RevenueEntity;

class Revenue extends Form {

    public function __construct($entityManager, $user) {

        parent::__construct('revenueForm');
        
        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RevenueEntity())
                ->setInputFilter(new InputFilter());
        
        $revenue = new Fieldset\Revenue($entityManager, $user);
        $revenue->setUseAsBaseFieldset(true);
        $this->add($revenue);
        
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
                'onclick' => "javascript: window.location.href = '/admin/financial/revenue'",
            )
        ));
    }
}
