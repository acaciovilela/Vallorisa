<?php

namespace DtlProposal\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlProposal\Entity\CaixaProposal as CaixaProposalEntity;

class CaixaProposal extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $userId) {
        
        parent::__construct('caixaProposal');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new CaixaProposalEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $proposal = new Proposal($entityManager, $userId);
        $proposal->setName('proposal')
                ->setLabel('Dados Gerais');
        $proposal->get('bank')->setAttribute('class', 'hide');
        $this->add($proposal);
    }

    public function getInputFilterSpecification() {
        return array();
    }

}
