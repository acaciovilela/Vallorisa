<?php

namespace DtlPerson\Form\Fieldset;

use Zend\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use DtlPerson\Entity\Individual as IndividualEntity;
use DtlBase\Validator\Cpf;

class Individual extends Fieldset implements InputFilterProviderInterface {

    protected $stateCode = array(
        'AC' => 'AC',
        'AL' => 'AL',
        'AM' => 'AM',
        'AP' => 'AP',
        'BA' => 'BA',
        'CE' => 'CE',
        'DF' => 'DF',
        'ES' => 'ES',
        'GO' => 'GO',
        'MA' => 'MA',
        'MG' => 'MG',
        'MS' => 'MS',
        'MT' => 'MT',
        'PA' => 'PA',
        'PB' => 'PB',
        'PE' => 'PE',
        'PI' => 'PI',
        'PR' => 'PR',
        'RJ' => 'RJ',
        'RN' => 'RN',
        'RO' => 'RO',
        'RR' => 'RR',
        'RS' => 'RS',
        'SC' => 'SC',
        'SE' => 'SE',
        'SP' => 'SP',
        'TO' => 'TO',
    );

    public function __construct($entityManager) {

        parent::__construct('individual');
        
        $this->setLabel('Dados de Pessoa Física');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new IndividualEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'cpf',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'CPF',
                'class' => 'form-control input-sm cpf',
            ),
            'options' => array(
                'label' => 'CPF'
            ),
        ));

        $this->add(array(
            'name' => 'rg',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'RG',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'RG'
            ),
        ));

        $this->add(array(
            'name' => 'rgOrgan',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Org. Expedidor',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Org. Exp.'
            ),
        ));
        $this->add(array(
            'name' => 'rgUf',
            'type' => 'Select',
            'attributes' => array(
                'placeholder' => 'UF',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'UF',
                'empty_option' => 'UF',
                'value_options' => $this->stateCode,
            ),
        ));
        
        $this->add(array(
            'name' => 'rgDate',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'placeholder' => 'Dt. de Expedição',
                'class' => 'form-control input-sm datepicker',
            ),
            'options' => array(
                'label' => 'Data de Expedição'
            ),
        ));
        
        $this->add(array(
            'name' => 'birthday',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'placeholder' => 'Data de Nasc.:',
                'class' => 'form-control input-sm datepicker',
            ),
            'options' => array(
                'label' => 'Data de Nasc.:'
            ),
        ));

        $this->add(array(
            'name' => 'birthDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Dia',
                'class' => 'form-control input-sm',
                'maxlength' => 2,
            ),
            'options' => array(
                'label' => 'Dia'
            ),
        ));

        $this->add(array(
            'name' => 'birthMonth',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'empty_option' => 'Mês',
                'value_options' => array(
                    '01' => 'JANEIRO',
                    '02' => 'FEVEREIRO',
                    '03' => 'MARÇO',
                    '04' => 'ABRIL',
                    '05' => 'MAIO',
                    '06' => 'JUNHO',
                    '07' => 'JULHO',
                    '08' => 'AGOSTO',
                    '09' => 'SETEMBRO',
                    '10' => 'OUTUBRO',
                    '11' => 'NOVEMBRO',
                    '12' => 'DEZEMBRO',
                ),
                'label' => 'Mês'
            )
        ));

        $this->add(array(
            'name' => 'birthYear',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Ano',
                'class' => 'form-control input-sm',
                'maxlength' => 4,
            ),
            'options' => array(
                'label' => 'Ano'
            ),
        ));

        $this->add(array(
            'name' => 'birthPlace',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Naturalidade',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Naturalidade'
            ),
        ));

        $this->add(array(
            'name' => 'birthUf',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'placeholder' => 'UF',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'UF',
                'empty_option' => 'UF',
                'value_options' => $this->stateCode,
            ),
        ));

        $this->add(array(
            'name' => 'mother',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Nome da Mãe',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Nome da Mãe'
            ),
        ));

        $this->add(array(
            'name' => 'father',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Nome do Pai',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Nome do Pai'
            ),
        ));

        $this->add(array(
            'name' => 'nationality',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'value_options' => array(
                    'BRASILEIRA' => 'BRASILEIRA',
                ),
                'label' => 'Nacionalidade'
            ),
        ));

        $this->add(array(
            'name' => 'gender',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
            'options' => array(
                'empty_option' => 'Sexo',
                'value_options' => array(
                    '0' => 'FEMININO',
                    '1' => 'MASCULINO'
                ),
                'label' => 'Sexo'
            ),
        ));
        
        $this->add(array(
            'name' => 'status',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control input-sm'
            ),
            'options' => array(
                'empty_option' => 'Selecione',
                'value_options' => array(
                    'AMAZIADO(A)' => 'AMAZIADO(A)',
                    'CASADO(A)' => 'CASADO(A)',
                    'DIVORCIADO(A)' => 'DIVORCIADO(A)',
                    'SOLTEIRO(A)' => 'SOLTEIRO(A)',
                    'VIÚVO(A)' => 'VIÚVO(A)',
                ),
                'label' => 'Estado Civil'
            ),
        ));

        $this->add(new Professional($entityManager));
    }

    public function getInputFilterSpecification() {
        return array(
            'rgOrgan' => array(
                'required' => false,
            ),
            'rgUf' => array(
                'required' => false,
            ),
            'rgDate' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Date()
                )
            ),
            'birthday' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Date()
                )
            ),
            'birthMonth' => array(
                'required' => false,
            ),
            'birthYear' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'Digits'),
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'Between', 'options' => array(
                            'min' => 1900,
                            'max' => date('Y') - 5,
                        )),
                ),
            ),
            'gender' => array(
                'required' => false,
            ),
            'cpf' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'Digits'),
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    new Cpf(),
                )
            ),
            'birthUf' => array(
                'required' => false,
            ),
            'status' => array(
                'required' => false,
            )
        );
    }

}
