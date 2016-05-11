<?php

namespace DtlProposal\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlProposal\Entity\Proposal as ProposalEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class ProposalStatus extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {

        parent::__construct('proposalStatus');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ProposalEntity());


        $this->add(array(
            'name' => 'proposal',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Novo Status da Proposta',
                'empty_option' => '',
                'value_options' => array(
                    'CHECKING' => 'ANÁLISE',
                    'CHECKING_IN' => 'ANÁLISE (MOVIMENTAÇÃO)',
                    'APPROVED' => 'APROVADA',
                    'CANCELED' => 'CANCELADA',
                    'ABORTED' => 'DESISTIU',
                    'INTEGRATED' => 'INTEGRADA',
                    'PENDING' => 'PENDENTE',
                    'REFUSED' => 'REPROVADA',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'onchange' => 'javascript: disableOff(this.value);',
                'required' => 'required'
            )
        ));

        $this->add(array(
            'name' => 'value',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'value',
            ),
            'options' => array(
                'label' => 'Valor Aprovado'
            ),
        ));

        $this->add(array(
            'name' => 'parcelAmount',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'parcelAmount',
            ),
            'options' => array(
                'label' => 'Parcelas'
            ),
        ));

        $this->add(array(
            'name' => 'parcelValue',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'parcelValue',
            ),
            'options' => array(
                'label' => 'Valor da Parcela',
            ),
        ));

        $this->add(array(
            'name' => 'baseDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm datepicker',
                'id' => 'baseDate',
            ),
            'options' => array(
                'label' => 'Nova Data Base'
            ),
        ));

        $this->add(array(
            'name' => 'notes',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'notes',
            ),
            'options' => array(
                'label' => 'Observações'
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'id' => array(
                'required' => true,
            ),
            'value' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR')),
                ),
            ),
            'parcelValue' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR')),
                ),
            ),
        );
    }

}
