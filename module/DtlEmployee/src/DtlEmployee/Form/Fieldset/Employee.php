<?php

namespace DtlEmployee\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlEmployee\Entity\Employee as EmployeeEntity;

class Employee extends ZendFielset implements InputFilterProviderInterface {

    protected $entityManager;

    public function __construct() {
        parent::__construct('employee');
    }

    public function init() {

        $this->setHydrator(new DoctrineHydrator($this->getEntityManager()))
                ->setObject(new EmployeeEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'admissionDate',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'class' => 'form-control input-sm datepicker',
            ),
            'options' => array(
                'label' => 'Data de Admissão'
            ),
        ));

        $this->add(array(
            'name' => 'demissionDate',
            'type' => 'Zend\Form\Element\Date',
            'attributes' => array(
                'class' => 'form-control input-sm datepicker',
            ),
            'options' => array(
                'label' => 'Data de Demissão',
            ),
        ));

        $this->add(array(
            'name' => 'workTime',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Carga Horária',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Carga Horária'
            ),
        ));

        $this->add(array(
            'name' => 'ctps',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'CTPS',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'CTPS'
            ),
        ));

        $this->add(array(
            'name' => 'ctpsSerie',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Série',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Série'
            ),
        ));

        $this->add(array(
            'name' => 'pis',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'PIS',
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'PIS'
            ),
        ));

        $this->add(array(
            'name' => 'salary',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Salário',
                'class' => 'form-control input-sm currency',
            ),
            'options' => array(
                'label' => 'Salário'
            ),
        ));

        $this->add(array(
            'name' => 'bonus',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Bônus',
                'class' => 'form-control input-sm currency',
            ),
            'options' => array(
                'label' => 'Bônus'
            ),
        ));

        $this->add(array(
            'name' => 'mark',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Meta de Contratos',
            ),
        ));

        $this->add(array(
            'name' => 'picture',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
                'placeholder' => 'Foto',
            ),
            'options' => array(
                'label' => 'Foto'
            ),
        ));

        $this->add(array(
            'name' => 'status',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'empty_option' => 'Selecione',
                'object_manager' => $this->getEntityManager(),
                'target_class' => 'DtlEmployeeStatus\Entity\EmployeeStatus',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC')
                    )
                ),
                'label' => 'Situação do Funcionário',
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));

        $this->add(array(
            'name' => 'office',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'empty_option' => 'Selecione',
                'object_manager' => $this->getEntityManager(),
                'target_class' => 'DtlOffice\Entity\Office',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC')
                    )
                ),
                'label' => 'Cargo'
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));

        $person = new \DtlPerson\Form\Fieldset\Person($this->getEntityManager());
        $person->setName('person')
                ->setLabel('Dados Pessoais');
        $this->add($person);

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'commissions',
            'options' => array(
                'label' => 'Comissões',
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'allow_remove' => true,
                'target_element' => array(
                    'type' => 'EmployeeCommissionFieldset',
                ),
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'admissionDate' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Date(),
                ),
            ),
            'demissionDate' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Date(),
                ),
            ),
            'status' => array(
                'required' => false,
            ),
            'office' => array(
                'required' => false,
            ),
            'salary' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Currency(),
                ),
            ),
            'bonus' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Currency(),
                ),
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

}
