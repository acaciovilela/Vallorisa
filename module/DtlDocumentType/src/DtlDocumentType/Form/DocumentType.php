<?php

namespace DtlDocumentType\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlDocumentType\Entity\DocumentType as DocumentTypeEntity;

class DocumentType extends Form {

    public function __construct($entityManager) {

        parent::__construct('documentType');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new DocumentTypeEntity())
                ->setInputFilter(new InputFilter());
        
        $documentType = new Fieldset\DocumentType($entityManager);
        $documentType->setUseAsBaseFieldset(true);
        $this->add($documentType);
        
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
                'onclick' => "javascript: window.location.href = '/admin/document-type'",
            )
        ));
    }
}
