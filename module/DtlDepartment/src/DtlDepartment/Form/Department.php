<?php

namespace DtlDepartment\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlDepartment\Entity\Department as DepartmentEntity;

class Department extends Form {

    public function __construct($entityManager) {

        parent::__construct('department');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new DepartmentEntity())
                ->setInputFilter(new InputFilter());
        
        $department = new Fieldset\Department($entityManager);
        $department->setUseAsBaseFieldset(true)
                ->setName('department');
        $this->add($department);
        
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
                'onclick' => "javascript: window.location.href = '/admin/department'",
            )
        ));
    }
}
