<?php

namespace DtlProposal\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlProposal\Entity\RealtyProposal as RealtyProposalEntity;

class RealtyProposal extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $userId) {
        
        parent::__construct('realtyProposal');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RealtyProposalEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'value',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'readonly' => 'readonly',
                'id' => 'realtyProposalTotalValue'
            ),
            'options' => array(
                'label' => 'Total dos Produtos',
            ),
        ));
        
        $this->add(array(
            'name' => 'inValue',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'realtyProposalInValue',
                'onblur' => 'javascript: calculateRealtyProposalValue(this.value);'
            ),
            'options' => array(
                'label' => 'Valor de Entrada',
            ),
        ));
        
        $this->add(array(
            'name' => 'fgts',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'id' => 'realtyProposalFgts',
            ),
            'options' => array(
                'label' => 'Usar recursos do FGTS',
                'label_attributes' => array(
                    'class' => 'checkbox'
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'commission',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Comissão Valoriza',
                'empty_option' => 'Selecione a Comissão',
                'object_manager' => $entityManager,
                'target_class' => 'DtlProposal\Entity\RealtyProposalCommission',
                'property' => 'value',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'isActive' => true
                        ),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
            )
        ));

        $this->add(array(
            'name' => 'realtor',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Corretor de Imóveis',
                'empty_option' => 'Selecione o Corretor',
                'object_manager' => $entityManager,
                'target_class' => 'DtlRealtor\Entity\Realtor',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'realtyProposalRealtorList',
                    'params' => array(
                        'user' => $userId,
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
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
                    'name' => 'productList',
                    'params' => array(
                        'category' => 'REALTY_CATEGORY',
                        'isActive' => true,
                    )
                )
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
                'id' => 'product',
            )
        ));
        
        $realty = new \DtlRealty\Form\Fieldset\Realty($entityManager);
        $realty->setName('realty')
                ->setLabel('Imóvel');
        $this->add($realty);
        
        $dealers = new \Zend\Form\Element\Collection();
        $dealers->setAllowAdd(true)
                ->setAllowRemove(true)
                ->setCount(2)
                ->setShouldCreateTemplate(true)
                ->setTargetElement(new \DtlDealer\Form\Fieldset\Dealer($entityManager))
                ->setLabel('Vendedores')
                ->setName('dealers');
        $this->add($dealers);
        
        $customers = new \Zend\Form\Element\Collection();
        $customers->setAllowAdd(true)
                ->setAllowRemove(true)
                ->setCount(1)
                ->setShouldCreateTemplate(true)
                ->setTargetElement(new \DtlCustomer\Form\Fieldset\Customer($entityManager))
                ->setLabel('Compradores')
                ->setName('customers');
        $this->add($customers);
        
        $proposal = new Proposal($entityManager, $userId);
        $proposal->setName('proposal')
                ->setLabel('Dados Gerais');
        $this->add($proposal);
    }

    public function getInputFilterSpecification() {
        return array(
            'realtor' => array('required' => true),
            'product' => array('required' => true),
            'totalValue' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Currency(),
                ),
            ),
            'inValue' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Currency(),
                ),
            ),
            'commission' => array(
                'required' => true,
                'filters' => array(
                    new \DtlBase\Filter\Porcent()
                )
            ),
        );
    }

}
