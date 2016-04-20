<?php

namespace DtlProposal\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;

class ProposalStatus extends ZendFielset implements InputFilterProviderInterface {

    public function __construct() {
        
        parent::__construct('proposalStatus');
        
        $this->add(array(
            'name' => 'proposalId',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'proposalStatusId',
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
            'name' => 'proposalStatusValue',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'proposalStatusValue',
            ),
            'options' => array(
                'label' => 'Valor Aprovado'
            ),
        ));

        $this->add(array(
            'name' => 'proposalStatusParcelAmount',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'proposalStatusParcelAmount',
            ),
            'options' => array(
                'label' => 'Parcelas'
            ),
        ));
        
        $this->add(array(
            'name' => 'proposalStatusParcelValue',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'proposalStatusParcelValue',
            ),
            'options' => array(
                'label' => 'Valor da Parcela',
            ),
        ));

        $this->add(array(
            'name' => 'proposalStatusBaseDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm datepicker',
                'id' => 'proposalStatusBaseDate',
            ),
            'options' => array(
                'label' => 'Nova Data Base'
            ),
        ));

        $this->add(array(
            'name' => 'proposalStatusNotes',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'proposalStatusNotes',
            ),
            'options' => array(
                'label' => 'Observações'
            ),
        ));

    }

    public function getInputFilterSpecification() {
        return array(
            'proposalStatusId' => array(
                'required' => true,
            ),
            'proposalStatusValue' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR')),
                ),
            ),
            'proposalStatusParcelValue' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR')),
                ),
            ),
        );
    }
}
