<?php

namespace DtlProposal\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlProposal\Entity\LoanProposal as LoanEntity;

class LoanProposal extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $userId) {
        
        parent::__construct('loan');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new LoanEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'benefitNumber',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'loanBenefitNumber'
            ),
            'options' => array(
                'label' => 'Nº do Benefício',
            ),
        ));
        
        $this->add(array(
            'name' => 'benefitUf',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'loanBenefitUf'
            ),
            'options' => array(
                'label' => 'UF',
            ),
        ));
        
        $this->add(array(
            'name' => 'otherLoan',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'loanOtherLoan',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Outros Empréstimos',
            ),
        ));
        
        $this->add(array(
            'name' => 'marginReservation',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'loanMarginReservation',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Reserva de Margem',
            ),
        ));
        
        $this->add(array(
            'name' => 'margin',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'loanMarginValue',
            ),
            'options' => array(
                'label' => 'Margem Consignável',
            ),
        ));
        
        $this->add(array(
            'name' => 'debts',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'loanDebts',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Débito Financeiro',
            ),
        ));
        
        $this->add(array(
            'name' => 'incoming',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'loanIncoming',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Outros Rendimentos',
            ),
        ));
        
        $this->add(array(
            'name' => 'partnerComission',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm porcent',
                'id' => 'loanPartnerComission',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Com. do Parceiro',
            ),
        ));
        
        $this->add(array(
            'name' => 'employeeComission',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm porcent',
                'id' => 'loanEmployeeComission',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Com. do Funcionário',
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
                    'name' => 'loanProposalShopmanList',
                    'params' => array(
                        'user' => $userId,
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
                'onchange' => 'javascript: 
                    fillSelect(this.value, "/admin/shopman/1/fillproduct", "product");'
            )
        ));

        $this->add(array(
            'name' => 'product',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Produto',
                'empty_option' => 'Selecione o Produto',
                'object_manager' => $entityManager,
                'target_class' => 'DtlProduct\Entity\Product',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC')
                    )
                )
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
                'id' => 'product',
            )
        ));
        
        $proposal = new Proposal($entityManager, $userId);
        $proposal->setName('proposal')
                ->setLabel('Dados Gerais');
        $this->add($proposal);
    }

    public function getInputFilterSpecification() {
        return array(
            'shopman' => array('required' => true),
            'product' => array('required' => true),
            'otherLoan' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'incoming' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'debts' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'margin' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'marginReservation' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'partnerComission' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'employeeComission' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
        );
    }
}
