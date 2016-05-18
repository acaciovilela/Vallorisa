<?php

namespace DtlEmployee\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlEmployee\Entity\Employee as EmployeeEntity;

class Employee extends Form {

    protected $entityManager;

    public function __construct() {
        parent::__construct('employee');
    }

    public function init() {

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($this->getEntityManager()))
                ->setObject(new EmployeeEntity())
                ->setInputFilter(new InputFilter());

        $this->add(array(
            'type' => 'EmployeeFieldset',
            'options' => array(
                'use_as_base_fieldset' => true,
            ),
        ));

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
                'onclick' => "javascript: window.location.href = '/admin/employee'",
            )
        ));
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

}
