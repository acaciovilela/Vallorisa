<?php

namespace DtlProposal\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlProposal\Entity\VehicleProposal as VehicleProposalEntity;

class VehicleProposal extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $userId) {
        
        parent::__construct('vehicleProposal');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new VehicleProposalEntity());

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
                'id' => 'value'
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
                'id' => 'inValue',
                'onblur' => 'javascript: calculateProposalValue(this.value);'
            ),
            'options' => array(
                'label' => 'Valor de Entrada',
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
                        'user' => $userId,
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
                'onchange' => 'javascript: 
                    fillSelect(this.value, "/admin/shopman/1/fill", "seller");
                    fillSelect(this.value, "/admin/shopman/1/fillproduct", "product");'
            )
        ));

        $this->add(array(
            'name' => 'seller',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Vendedor',
                'empty_option' => 'Selecione o Vendedor',
                'object_manager' => $entityManager,
                'target_class' => 'DtlSeller\Entity\Seller',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                    )
                )
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
                'id' => 'seller'
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
                        'criteria' => array(
                            'user' => $userId
                        ),
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
            'seller' => array('required' => true),
            'product' => array('required' => true),
            'value' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'inValue' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
        );
    }

}
