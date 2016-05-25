<?php

namespace DtlProposal\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlProposal\Entity\RealtyProposal as RealtyProposalEntity;

class RealtyProposal extends ZendFielset implements InputFilterProviderInterface {

    protected $entityManager;
    protected $user;

    public function __construct() {
        parent::__construct('realtyProposal');
    }

    public function init() {

        $this->setHydrator(new DoctrineHydrator($this->getEntityManager()))
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
                'object_manager' => $this->getEntityManager(),
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
            )
        ));

        $this->add(array(
            'name' => 'realtor',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Corretor de Imóveis',
                'empty_option' => 'Selecione o Corretor',
                'object_manager' => $this->getEntityManager(),
                'target_class' => 'DtlRealtor\Entity\Realtor',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'realtyProposalRealtorList',
                    'params' => array(),
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
                'object_manager' => $this->getEntityManager(),
                'target_class' => 'DtlProduct\Entity\Product',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findByCategoryType',
                    'params' => array(
                        'category' => 'REALTY_CATEGORY',
                    )
                )
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
                'id' => 'product',
            )
        ));

        $realty = new \DtlRealty\Form\Fieldset\Realty($this->getEntityManager());
        $realty->setName('realty')
                ->setLabel('Imóvel');
        $this->add($realty);

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'dealers',
            'options' => array(
                'label' => 'Vendedores',
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'allow_remove' => true,
                'target_element' => array(
                    'type' => 'DealerFieldset',
                ),
            ),
        ));

        $customers = new \Zend\Form\Element\Collection();
        $customers->setAllowAdd(true)
                ->setAllowRemove(true)
                ->setCount(1)
                ->setShouldCreateTemplate(true)
                ->setTargetElement(new \DtlCustomer\Form\Fieldset\Customer($this->getEntityManager()))
                ->setLabel('Compradores')
                ->setName('customers');
        $customers->getTargetElement()->get('person')->get('name')->setAttribute('required', '');
        $this->add($customers);

        $proposal = new Proposal($this->getEntityManager(), $this->getUser());
        $proposal->setName('proposal')
                ->setLabel('Dados Gerais');
        $this->add($proposal);
    }

    public function getInputFilterSpecification() {
        return array(
            'realtor' => array('required' => true),
            'product' => array('required' => true),
            'value' => array(
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
            'dealers' => array(
                'person' => array(
                    'name' => array(
                        'required' => true,
                    ),
                )
            ),
            'commission' => array(
                'required' => false,
            ),
            'fgts' => array(
                'required' => false,
            ),
        );
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

}
