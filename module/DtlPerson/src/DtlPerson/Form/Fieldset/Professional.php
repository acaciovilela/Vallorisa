<?php

namespace DtlPerson\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use DtlPerson\Entity\Professional as ProfessionalEntity;

class Professional extends Fieldset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('professional');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ProfessionalEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'inDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Data de Admissão',
                'class' => 'form-control  datepicker',
            ),
            'options' => array(
                'label' => 'Data de Admissão'
            ),
        ));

        $this->add(array(
            'name' => 'companyName',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Nome da Empresa',
                'class' => 'form-control ',
            ),
            'options' => array(
                'label' => 'Nome da Empresa'
            ),
        ));

        $this->add(array(
            'name' => 'companyCnpj',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'CNPJ',
                'class' => 'form-control  cnpj',
            ),
            'options' => array(
                'label' => 'CNPJ'
            ),
        ));

        $this->add(array(
            'name' => 'salary',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Salário',
                'class' => 'form-control currency',
            ),
            'options' => array(
                'label' => 'Salário'
            ),
        ));

        $this->add(array(
            'name' => 'otherRevenue',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Outra Receita',
                'class' => 'form-control  currency',
            ),
            'options' => array(
                'label' => 'Outra Receita'
            ),
        ));

        $this->add(array(
            'name' => 'notes',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'placeholder' => 'Observações',
                'class' => 'form-control ',
            ),
            'options' => array(
                'label' => 'Observações'
            ),
        ));
        
        $this->add(array(
            'name' => 'office',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Cargo',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlOffice\Entity\Office',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control ',
            )
        ));

        $address = new Address($entityManager);
        $address->setLabel('Dados de Endereço')
                ->setName('address');
        $this->add($address);

        $contact = new Contact($entityManager);
        $contact->setName('contact')
                ->setLabel('Dados de Contato');
        $this->add($contact);
    }

    public function getInputFilterSpecification() {
        return array(
            'companyCnpj' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\Filter\Digits()
                ),
            ),
            'salary' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Currency()
                ),
            ),
            'otherRevenue' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Currency()
                ),
            ),
            'inDate' => array(
                'required' => false,
            ),
            'office' => array(
                'required' => false,
            ),
        );
    }

}
