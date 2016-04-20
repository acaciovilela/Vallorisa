<?php

namespace DtlDocumentType\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlDocumentType\Entity\DocumentType as DocumentTypeEntity;

class DocumentType extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('documentType');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new DocumentTypeEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Tipo de Documento',
                'class'         => 'form-control ',
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Tipo de Documento'
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true,
            ),
        );
    }
}
