<?php

namespace DtlShopman\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlShopman\Entity\Shopman as ShopmanEntity;

class Shopman extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('shopman');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ShopmanEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $person = new \DtlPerson\Form\Fieldset\Person($entityManager);
        $person->setName('person')
                ->setLabel('Dados Gerais');
        $this->add($person);

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'variantComission',
            'options' => array(
                'label' => 'Comissão Percentual',
            ),
            'attributes' => array(
                'placeholder' => 'Comissão Percentual',
                'class' => 'form-control input-sm porcent'
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'fixedComission',
            'options' => array(
                'label' => 'Comissão Fixa',
            ),
            'attributes' => array(
                'placeholder' => 'Comissão Fixa',
                'class' => 'form-control input-sm currency'
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'company',
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'id' => array(
                'required' => false,
            ),
        );
    }

}
