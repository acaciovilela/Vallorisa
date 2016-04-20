<?php

namespace DtlProduct\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlProduct\Entity\Category as CategoryEntity;

class Category extends Form {

    public function __construct($entityManager) {

        parent::__construct('category');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new CategoryEntity())
                ->setInputFilter(new InputFilter());
        
        $category = new Fieldset\Category($entityManager);
        $category->setUseAsBaseFieldset(true)
                ->setName('category');
        $this->add($category);
        
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
                'onclick' => "javascript: window.location.href = '/admin/category'",
            )
        ));
    }
}
