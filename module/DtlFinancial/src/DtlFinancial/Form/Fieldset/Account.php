<?php

namespace DtlFinancial\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlFinancial\Entity\Account as AccountEntity;

class Account extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager, $user, $true = 1) {
        parent::__construct('account');

        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new AccountEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'description',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Descrição',
            ),
        ));

        $this->add(array(
            'name' => 'number',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Número'
            ),
        ));

        $this->add(array(
            'name' => 'emissionDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm  datepicker',
            ),
            'options' => array(
                'label' => 'Dt. de Emissão'
            ),
        ));

        $this->add(array(
            'name' => 'expirationDate',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm  datepicker',
                'id' => 'firstExpiration',
                'onblur' => 'javascript: $("#ParcelExpiration").val(this.value);'
            ),
            'options' => array(
                'label' => 'Dt. de Vencimento'
            ),
        ));

        $this->add(array(
            'name' => 'value',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm  currency',
                'id' => 'Value',
                'onblur' => 'javascript: $("#ParcelValue").val(this.value);'
            ),
            'options' => array(
                'label' => 'Valor'
            ),
        ));

        $this->add(array(
            'name' => 'parcels',
            'type' => 'Zend\Form\Element\Number',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'maxlength' => 3,
                'id' => 'parcelValue',
                'min' => '1',
                'max' => '999',
                'step' => '1',
            ),
            'options' => array(
                'label' => 'Qtd. de Ocorrências'
            ),
        ));

        $this->add(array(
            'name' => 'currentParcel',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Parcela'
            ),
        ));

        $this->add(array(
            'name' => 'barcode',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'label' => 'Código de Barras'
            ),
        ));

        $this->add(array(
            'name' => 'autoLaunch',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'value_options' => array(
                    0 => 'MANUAL',
                    1 => 'AUTOMÁTICO',
                ),
                'label' => 'Tipo de Lançamento'
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            )
        ));

        $this->add(array(
            'name' => 'fine',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm porcent'
            ),
            'options' => array(
                'value' => '0',
                'label' => 'Multa'
            )
        ));

        $this->add(array(
            'name' => 'interest',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm porcent'
            ),
            'options' => array(
                'label' => 'Juros'
            ),
        ));

        $this->add(array(
            'name' => 'interestInterval',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'value_options' => array(
                    1 => 'DIARIAMENTE',
                    30 => 'MENSALMENTE',
                ),
                'label' => 'Interv. dos Juros'
            ),
        ));

        $this->add(array(
            'name' => 'isRecurrent',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'value_options' => array(
                    0 => 'NÃO',
                    1 => 'SIM',
                ),
                'label' => 'É recorrente?'
            ),
            'attributes' => array(
                'class' => 'form-control input-sm'
            )
        ));

        $this->add(array(
            'name' => 'recurrenceInterval',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
            'options' => array(
                'value_options' => array(
                    30 => 'MENSALMENTE',
                    60 => 'BIMESTRALMENTE',
                    90 => 'TRIMESTRALMENTE',
                    180 => 'SEMESTRALMENTE',
                    365 => 'ANUALMENTE',
                    730 => 'BIENALMENTE',
                    1095 => 'TRIENALMENTE',
                ),
                'label' => 'Interv. da Ocorrência'
            ),
        ));

        $this->add(array(
            'name' => 'notes',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'rows' => 4,
            ),
            'options' => array(
                'label' => 'Observações'
            ),
        ));

        $this->add(array(
            'name' => 'currentAccount',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Conta',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlCurrentAccount\Entity\CurrentAccount',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'user' => $user,
                        ),
                        'orderBy' => array('name' => 'ASC'),
                    ),
                ),
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));

        $this->add(array(
            'name' => 'paymentType',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Forma de Pagamento',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlPaymentType\Entity\PaymentType',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'user' => $user,
                        ),
                        'orderBy' => array('name' => 'ASC')
                    )
                )
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));

        $this->add(array(
            'name' => 'documentType',
            'type' => 'DoctrineORMModule\Form\Element\EntitySelect',
            'options' => array(
                'label' => 'Tipo de Documento',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlDocumentType\Entity\DocumentType',
                'property' => 'name',
                'is_method' => true,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'user' => $user,
                        ),
                        'orderBy' => array(
                            'name' => 'ASC'
                        )
                    )
                )
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            )
        ));

        $this->add(array(
            'name' => 'accountingItem',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'options' => array(
                'label' => 'Ítem Contábil',
                'empty_option' => 'Selecione',
                'object_manager' => $entityManager,
                'target_class' => 'DtlAccountingItem\Entity\AccountingItem',
                'property' => 'name',
                'is_method' => false,
                'find_method' => array(
                    'name' => 'findBy',
                    'params' => array(
                        'criteria' => array(
                            'type' => $true,
                            'user' => $user,
                        ),
                        'orderBy' => array(
                            'type' => 'ASC',
                            'name' => 'ASC'
                        ),
                    )
                )
            ),
            'attributes' => array(
                'class' => 'form-control input-sm',
            ),
        ));
    }

    public function getInputFilterSpecification() {
        return array(
            'description' => array(
                'required' => true,
                'filters' => array(
                    new \Zend\Filter\HtmlEntities()
                )
            ),
            'parcels' => array(
                'required' => true,
                'filters' => array(
                    new \Zend\Filter\Digits(),
                ),
            ),
            'value' => array(
                'required' => true,
                'filters' => array(
                    new \DtlBase\Filter\Currency()
                ),
            ),
            'fine' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Porcent()
                ),
            ),
            'interest' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Porcent()
                ),
            ),
            'emissionDate' => array(
                'required' => false,
                'filters' => array(
                    new \DtlBase\Filter\Date()
                ),
            ),
            'expirationDate' => array(
                'required' => true,
                'filters' => array(
                    new \DtlBase\Filter\Date()
                ),
            ),
            'currentAccount' => array(
                'required' => false,
            ),
            'paymentType' => array(
                'required' => false,
            ),
            'documentType' => array(
                'required' => false,
            ),
            'accountingItem' => array(
                'required' => false,
            ),
        );
    }

}
