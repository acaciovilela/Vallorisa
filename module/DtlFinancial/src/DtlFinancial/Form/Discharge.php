<?php

namespace DtlFinancial\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlFinancial\Entity\Discharge as DischargeEntity;

class Discharge extends Form {

    public function __construct($entityManager) {

        parent::__construct('dischargeForm');
        
        $this->setBindOnValidate(false);
        
        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new DischargeEntity())
                ->setInputFilter(new InputFilter());
        
        $discharge = new Fieldset\Discharge($entityManager);
        $discharge->setUseAsBaseFieldset(true);
        $this->add($discharge);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-primary'
            )
        ));
    }
}
