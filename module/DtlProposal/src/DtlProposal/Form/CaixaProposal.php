<?php

namespace DtlProposal\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlProposal\Entity\CaixaProposal as CaixaProposalEntity;

class CaixaProposal extends Form {

    public function __construct($entityManager, $user) {

        parent::__construct('caixaProposal');

        $this->setAttribute('method', 'post')
                ->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new CaixaProposalEntity())
                ->setInputFilter(new InputFilter());

        $caixaProposal = new Fieldset\CaixaProposal($entityManager, $user);
        $caixaProposal->setUseAsBaseFieldset(true);
        $this->add($caixaProposal);
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-primary'
            )
        ));

        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'button',
                'value' => 'Cancel',
                'class' => 'btn btn-default',
                'onclick' => 'javascript: window.location.href = "/admin/proposal/vehicle-proposal";'
            )
        ));
    }
}
