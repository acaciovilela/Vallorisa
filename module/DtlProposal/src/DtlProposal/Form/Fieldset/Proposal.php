<?php

namespace DtlProposal\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlProposal\Entity\Proposal as ProposalEntity;

class Proposal extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {

        parent::__construct('proposal');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new ProposalEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'number',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'readonly' => 'readonly'
            ),
            'options' => array(
                'label' => 'Número'
            ),
        ));

        $this->add(array(
            'name' => 'value',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'proposalValue',
                'value' => 0.00,
            ),
            'options' => array(
                'label' => 'Valor Solicitado'
            ),
        ));

        $this->add(array(
            'name' => 'parcelAmount',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'proposalParcelAmount',
                'value' => 1,
                'onblur' => 'javascript: calculateProposal(this.value);'
            ),
            'options' => array(
                'label' => 'Parcelas'
            ),
        ));

        $this->add(array(
            'name' => 'parcelValue',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm currency',
                'id' => 'proposalParcelValue',
                'value' => 0.00,
            ),
            'options' => array(
                'label' => 'Valor da Parcela',
            ),
        ));

        $this->add(array(
            'name' => 'date',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm datepicker',
                'id' => 'proposalDate',
                'value' => date('d/m/Y'),
            ),
            'options' => array(
                'label' => 'Data da Proposta'
            ),
        ));

        $this->add(array(
            'name' => 'startDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'proposalStartDate',
                'readonly' => 'readonly',
            ),
            'options' => array(
                'label' => 'Venc. 1ª Parcela'
            ),
        ));

        $this->add(array(
            'name' => 'endDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'proposalEndDate',
                'readonly' => 'readonly',
            ),
            'options' => array(
                'label' => 'Venc. Última Parcela'
            ),
        ));

        $this->add(array(
            'name' => 'baseDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'proposalBaseDate',
                'value' => date('d/m/Y'),
                'readonly' => 'readonly',
            ),
            'options' => array(
                'label' => 'Data Base'
            ),
        ));

        $this->add(array(
            'name' => 'comission',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'id' => 'proposalComission',
            ),
            'options' => array(
                'label' => 'Comissão',
                'value_options' => array(
                    '0.00' => '00,00',
                    '1.00' => '01,00',
                    '2.00' => '02,00',
                    '3.00' => '03,00',
                    '4.00' => '04,00',
                    '5.00' => '05,00',
                    '6.00' => '06,00',
                    '7.00' => '07,00',
                    '8.00' => '08,00',
                    '9.00' => '09,00',
                    '10.00' => '10,00',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'notes',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Observações'
            ),
        ));

        $this->add(array(
            'name' => 'company',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Empresa',
                'empty_option' => 'Selecione a Empresa',
                'object_manager' => $entityManager,
                'target_class' => 'DtlCompany\Entity\Company',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'isActive' => true
                        ),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
            )
        ));

        $this->add(array(
            'name' => 'employee',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'empty_option' => 'Selecione',
                'label' => 'Operador',
                'object_manager' => $entityManager,
                'target_class' => 'DtlEmployee\Entity\Employee',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'isActive' => true,
                        ),
                    ),
                ),
            ),
            'attributes' => array(
                'readonly' => 'readonly',
                'class' => 'form-control input-sm',
            )
        ));

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

        $customer = new \DtlCustomer\Form\Fieldset\Customer($entityManager);
        $customer->setName('customer')
                ->setLabel('Cliente');
        $this->add($customer);
    }

    public function getInputFilterSpecification() {
        return array(
            'employee' => array('required' => false),
            'company' => array('required' => true),
            'bank' => array('required' => true),
            'value' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Currency()
                ),
            ),
            'parcelValue' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Currency()
                ),
            ),
            'comission' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Porcent()
                ),
            ),
        );
    }

}
