<?php

namespace DtlProposal\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;

class Search extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $user) {

        parent::__construct('search');

        $this->add(array(
            'name' => 'proposalStatus',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Status da Proposta',
                'empty_option' => 'Selecione',
                'value_options' => array(
                    'CHECKING' => 'ABERTA',
                    'APPROVED' => 'APROVADA',
                    'CANCELED' => 'CACELADA',
                    'ABORTED' => 'ABORTADA',
                    'INTEGRATED' => 'INTEGRADA',
                    'PENDING' => 'PENDENTE',
                    'REFUSED' => 'REPROVADA',
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));

        $this->add(array(
            'name' => 'customerName',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Nome do Cliente',
                'class' => 'form-control input-sm',
                'id' => 'customerName'
            ),
            'options' => array(
                'label' => 'Nome do Cliente',
            ),
        ));

        $this->add(array(
            'name' => 'proposalId',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Cód. da Proposta',
                'class' => 'form-control input-sm',
                'id' => 'customerName'
            ),
            'options' => array(
                'label' => 'Cód. da Proposta',
            ),
        ));

        $this->add(array(
            'name' => 'shopman',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Lojista',
                'empty_option' => 'Selecione o Lojista',
                'object_manager' => $entityManager,
                'target_class' => 'DtlShopman\Entity\Shopman',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'vehicleProposalShopmanList',
                    'params' => array(
                        'user' => $user,
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));

        $this->add(array(
            'name' => 'bank',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Banco',
                'empty_option' => 'Selecione o Banco',
                'object_manager' => $entityManager,
                'target_class' => 'DtlBank\Entity\Bank',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC')
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));

        $this->add(array(
            'name' => 'proposalDateFrom',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Propostas de',
                'class' => 'form-control input-sm datepicker',
                'id' => 'proposalDateFrom'
            ),
            'options' => array(
                'label' => 'Propostas de',
            ),
        ));

        $this->add(array(
            'name' => 'proposalDateTo',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Até',
                'class' => 'form-control input-sm datepicker',
                'id' => 'proposalDateTo'
            ),
            'options' => array(
                'label' => 'Até',
            ),
        ));

        $this->add(array(
            'name' => 'company',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Empresa',
                'empty_option' => 'Selecione a Empresa',
                'object_manager' => $entityManager,
                'target_class' => 'DtlCompany\Entity\Company',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'isActive' => true,
                        ),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));
    }

    public function getInputFilterSpecification() {
        return array();
    }

}
