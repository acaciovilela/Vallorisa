<?php

namespace DtlCurrency\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlCurrency\Entity\Currency as CurrencyEntity;

class Currency extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('currency');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new CurrencyEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Moeda',
                'class'         => 'form-control input-sm',
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Nome da Moeda'
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
