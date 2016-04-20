<?php

namespace DtlProposal\Form\Fieldset;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DtlProposal\Entity\RealtyEvaluation as RealtyEvaluationEntity;

class RealtyEvaluation extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('realtyEvaluation');
        
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new RealtyEvaluationEntity());
        
        $this->add(array(
            'name' => 'bank',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Banco',
                'empty_option' => 'Selecione o Banco',
                'object_manager' => $entityManager,
                'target_class' => 'DtlBank\Entity\Bank',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC')
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
            )
        ));
        
        $this->add(array(
            'name' => 'requestDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm datepicker',
                'id' => 'realtyEvaluationRequestDate',
                'value' => date('d/m/Y'),
                'placeholder' => 'Data da Solicitação'
            ),
            'options' => array(
                'label' => 'Data da Solicitação'
            ),
        ));
        
        $this->add(array(
            'name' => 'completionDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm datepicker',
                'id' => 'realtyEvaluationCompletionDate',
                'placeholder' => 'Data da Avaliação',
                'value' => date('d/m/Y'),
            ),
            'options' => array(
                'label' => 'Data da Avaliação',
            ),
        ));
        
        $this->add(array(
            'name' => 'engineering',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'realtyEvaluationEngineering',
                'placeholder' => 'Engenharia'
            ),
            'options' => array(
                'label' => 'Engenharia'
            ),
        ));
        
        $this->add(array(
            'name' => 'engineeringPhone',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm phone',
                'id' => 'realtyEvaluationEngineeringPhone',
                'placeholder' => 'Tel. da Engenharia'
            ),
            'options' => array(
                'label' => 'Tel. da Engenharia'
            ),
        ));
        
        $this->add(array(
            'name' => 'engineer',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'realtyEvaluationEngineer',
                'placeholder' => 'Engenheiro'
            ),
            'options' => array(
                'label' => 'Engenheiro'
            ),
        ));
        
        $this->add(array(
            'name' => 'engineerPhone',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm phone',
                'id' => 'realtyEvaluationEngineerPhone',
                'placeholder' => 'Tel. do Engenheiro'
            ),
            'options' => array(
                'label' => 'Tel. do Engenheiro'
            ),
        ));
        
        $this->add(array(
            'name' => 'value',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'realtyEvaluationValue',
                'placeholder' => 'Valor Avaliado'
            ),
            'options' => array(
                'label' => 'Valor Avaliado'
            ),
        ));
        
    }

    public function getInputFilterSpecification() {
        return array(
            'bank' => array(
                'required' => true,
            ),
            'value' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'))
                ),
            ),
            'requestDate' => array(
                'required' => false,
                'filters' => array(
                ),
            ),
            'completionDate' => array(
                'required' => false,
                'filters' => array(
                ),
            ),
            'engineeringPhone' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\Filter\Digits()
                ),
            ),
            'engineerPhone' => array(
                'required' => false,
                'filters' => array(
                    new \Zend\Filter\Digits()
                ),
            ),
        );
    }
}
