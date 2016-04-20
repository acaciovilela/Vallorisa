<?php

namespace DtlPerson\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
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

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new IndividualEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'cpf',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'CPF',
                'class' => 'form-control  cpf',
            ),
            'options' => array(
                'label' => 'CPF'
            ),
        ));
        
        $this->add(array(
            'name' => 'rg',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'RG',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'RG'
            ),
        ));

        $this->add(array(
            'name' => 'birthDay',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Dia',
                'class' => 'form-control ',
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
                'class' => 'form-control ',
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
                'placeholder'   => 'Ano',
                'class'         => 'form-control ',
                'maxlength'     => 4,
            ),
            'options' => array(
                'label' => 'Ano'
            ),
        ));
        
        $this->add(array(
            'name' => 'birthPlace',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Naturalidade',
                'class'         => 'form-control ',
            ),
            'options' => array(
                'label' => 'Naturalidade'
            ),
        ));
        
        $this->add(array(
            'name' => 'birthUf',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'placeholder'   => 'UF',
                'class'         => 'form-control ',
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
                'placeholder'   => 'Nome da Mãe',
                'class'         => 'form-control ',
            ),
            'options' => array(
                'label' => 'Nome da Mãe'
            ),
        ));
        
        $this->add(array(
            'name' => 'father',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Nome do Pai',
                'class'         => 'form-control ',
            ),
            'options' => array(
                'label' => 'Nome do Pai'
            ),
        ));
        
        $this->add(array(
            'name' => 'nationality',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Nacionalidade',
                'class'         => 'form-control ',
            ),
            'options' => array(
                'label' => 'Nacionalidade'
            ),
        ));
        
        $this->add(array(
            'name' => 'gender',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control '
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
        
        $professional = new \DtlPerson\Form\Fieldset\Professional($entityManager);
        $professional->setName('professional')
                ->setLabel('Dados Profissionais');
        $this->add($professional);
    }

    public function getInputFilterSpecification() {
        return array(
            'birthDay' => array(
                'required' => false,
                'filters' => array(
                    array('name' => 'Digits'),
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array('name' => 'Between', 'options' => array(
                        'min' => 1,
                        'max' => 31,
                    )),
                ),
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
        );
    }
}
