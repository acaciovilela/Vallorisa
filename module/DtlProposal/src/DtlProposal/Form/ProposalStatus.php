<?php

namespace DtlProposal\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlProposal\Entity\Proposal as ProposalEntity;

class ProposalStatus extends Form {

    public function __construct($entityManager) {

        parent::__construct('proposalStatus');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ProposalEntity())
                ->setInputFilter(new InputFilter());
        
        $proposalSatus = new Fieldset\ProposalStatus($entityManager);
        $proposalSatus->setUseAsBaseFieldset(true);
        $this->add($proposalSatus);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-primary'
            )
        ));
    }
}
