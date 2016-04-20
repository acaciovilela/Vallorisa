<?php

namespace DtlProposal\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlProposal\Entity\RealtyProposalCommission as RealtyProposalCommissionEntity;

class RealtyProposalCommission extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('realtyProposalCommission');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RealtyProposalCommissionEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'value',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm porcent',
                'id' => 'realtyProposalCommissionValue',
                'placeholder' => 'Valor da Comissão',
            ),
            'options' => array(
                'label' => 'Valor da Comissão',
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'value' => array(
                'required' => true,
                'filters' => array(
                    new \DtlBase\Filter\Porcent(),
                ),
            ),
        );
    }

}
