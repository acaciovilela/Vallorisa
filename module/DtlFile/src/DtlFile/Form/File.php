<?php

namespace DtlFile\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class File extends Form {

    public function __construct($entityManager) {

        parent::__construct('file_form');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setInputFilter(new InputFilter());
        
        $file = new Fieldset\File($entityManager);
        $file->setUseAsBaseFieldset(true)
                ->setName('file');
        $this->add($file);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Button',
            'name' => 'upload-button',
            'attributes' => array(
                'value' => 'Enviar',
                'class' => 'btn btn-primary'
            )
        ));
    }
}
