<?php

namespace DtlFile\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;

class File extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('file');
        
        $this->setHydrator(new DoctrineHydrator($entityManager));

        $this->add(array(
            'name' => 'file-upload',
            'type' => 'Zend\Form\Element\File',
            'options' => array(
                'label' => 'Upload de Arquivo'
            ),
            'attributes' => array(
                'id' => 'file-upload'
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            
        );
    }

}
