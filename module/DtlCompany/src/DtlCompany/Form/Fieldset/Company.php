<?php

namespace DtlCompany\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlCompany\Entity\Company as CompanyEntity;

class Company extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {

        parent::__construct('company');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new CompanyEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Razão Social',
                'class' => 'form-control input-sm',
                'required' => 'required',
                'width' => '200px',
            ),
            'options' => array(
                'label' => 'Razão Social',
            )
        ));

        $this->add(array(
            'name' => 'isMaster',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Tipo',
                'value_options' => array(
                    '0' => 'Filial',
                    '1' => 'Matriz',
                ),
            )
        ));

        $this->add(array(
            'name' => 'fancyName',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Nome da Fantasia',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Nome Fantasia',
            )
        ));

        $this->add(array(
            'name' => 'cnpj',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'CNPJ',
                'class' => 'form-control input-sm cnpj',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'CNPJ',
            )
        ));

        $this->add(array(
            'name' => 'subscription',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Inscrição Estadual',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Inscrição Estadual',
            )
        ));

        $this->add(array(
            'name' => 'representativeName',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Nome do Representante',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Nome do Representante',
            )
        ));

        $this->add(array(
            'name' => 'representativePhone',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Tel. do Repres.',
                'class' => 'form-control input-sm phone',
            ),
            'options' => array(
                'label' => 'Telefone do Rep.',
            )
        ));

        $this->add(array(
            'name' => 'timestamp',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'isActive',
            'type' => 'Zend\Form\Element\Hidden'
        ));

        $address = new \DtlPerson\Form\Fieldset\Address($entityManager);
        $address->setLabel('Dados de Endereço')
                ->setName('address');
        $this->add($address);

        $contact = new \DtlPerson\Form\Fieldset\Contact($entityManager);
        $contact->setName('contact')
                ->setLabel('Dados de Contato');
        $this->add($contact);
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true
            ),
            'representativePhone' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'Digits'
                    )
                )
            ),
            'cnpj' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'Digits'),
                ),
                'validators' => array(
                    new \DtlBase\Validator\Cnpj(),
                ),
            ),
        );
    }

}
