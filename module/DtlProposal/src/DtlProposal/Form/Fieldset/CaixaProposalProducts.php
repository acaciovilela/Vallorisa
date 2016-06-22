<?php

namespace DtlProposal\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlProposal\Entity\CaixaProposalProducts as CaixaProposalEntity;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class CaixaProposalProducts extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {

        parent::__construct('products');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new CaixaProposalEntity());
        
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
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
                    'name' => 'findByCategoryType',
                    'params' => array(
                        'category' => 'CAIXA_CATEGORY'
                    )
                )
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));
        
        $this->add(array(
            'name' => 'remove',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => array(
                'class' => 'btn btn-sm btn-default remove-product',
                'onclick' => 'javascript: return removeCaixaProduct();',
                'value' => 'Remover'
            ),
            'options' => array(
                'label' => 'Apagar',
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'product' => array(
                'required' => false,
            ),
        );
    }

}
