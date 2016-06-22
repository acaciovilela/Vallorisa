<?php

namespace DtlProposal\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlProposal\Entity\CaixaProposal as CaixaProposalEntity;

class CaixaProposal extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {

        parent::__construct('caixaProposal');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new CaixaProposalEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $proposal = new Proposal($entityManager);
        $proposal->setName('proposal')
                ->setLabel('Dados Gerais');
        $proposal->get('bank')->setAttribute('class', 'hide');
        $this->add($proposal);

        $products = new \Zend\Form\Element\Collection();
        $products->setAllowAdd(true)
                ->setAllowRemove(true)
                ->setTargetElement(new CaixaProposalProducts($entityManager))
                ->setShouldCreateTemplate(true)
                ->setCount(1)
                ->setName('products')
                ->setLabel('Produtos');
        $this->add($products);
    }

    public function getInputFilterSpecification() {
        return array();
    }

}
