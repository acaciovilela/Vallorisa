<?php

namespace DtlBusiness\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlBusiness\Entity\Business as BusinessEntity;

class Business extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('business');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new BusinessEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Nome da Ramo de Atividade',
                'class'         => 'form-control input-sm',
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Nome da Ramo de Atividade'
            ),
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
