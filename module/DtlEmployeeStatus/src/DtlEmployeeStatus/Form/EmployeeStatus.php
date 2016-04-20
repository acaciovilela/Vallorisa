<?php

namespace DtlEmployeeStatus\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlEmployeeStatus\Entity\EmployeeStatus as EmployeeStatusEntity;

class EmployeeStatus extends Form {

    public function __construct($entityManager) {

        parent::__construct('employeeStatus');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new EmployeeStatusEntity())
                ->setInputFilter(new InputFilter());
        
        $employeeStatus = new Fieldset\EmployeeStatus($entityManager);
        $employeeStatus->setUseAsBaseFieldset(true);
        $this->add($employeeStatus);
        
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
                'onclick' => "javascript: window.location.href = '/admin/employeestatus'",
            )
        ));
    }
}
