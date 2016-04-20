<?php

namespace DtlBase;

return array(
    'view_helpers' => array(
        'invokables' => array(
            'formElementError' => 'DtlBase\Form\View\Helper\FormElementError',
            'phone' => 'DtlBase\View\Helper\Phone',
            'cep' => 'DtlBase\View\Helper\Cep',
            'currency' => 'DtlBase\View\Helper\Currency',
            'porcent' => 'DtlBase\View\Helper\Porcent',
            'date' => 'DtlBase\View\Helper\Date',
            'cpf' => 'DtlBase\View\Helper\Cpf',
            'cnpj' => 'DtlBase\View\Helper\Cnpj',
            'gender' => 'DtlBase\View\Helper\Gender',
            'birthday' => 'DtlBase\View\Helper\Birthday',
            'deleteModal' => 'DtlBase\View\Helper\DeleteModal',
            'dtlBaseCollection' => 'DtlBase\Form\Helper\Collection',
            'dtlBaseFormRow' => 'DtlBase\Form\Helper\FormRow',
            'dtlBaseFormDate' => 'DtlBase\Form\Helper\FormDate',
            'info' => 'DtlBase\View\Helper\Message\Info',
            'warning' => 'DtlBase\View\Helper\Message\Warning',
            'error' => 'DtlBase\View\Helper\Message\Error',
            'success' => 'DtlBase\View\Helper\Message\Success',
            'block' => 'DtlBase\View\Helper\Message\Block',
            'dump' => 'DtlBase\View\Helper\Dump',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'convertToCurrency' => 'DtlBase\Controller\Plugin\Currency',
        ),
    ),
    'validators' => array(
        'invokables' => array(
            'Cnpj' => 'DtlBase\Validator\Cnpj',
            'Cpf' => 'DtlBase\Validator\Cpf',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'dtlbase' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'configuration' => array(
            'orm_default' => array(
                'types' => array(
                    'datebr' => 'DtlBase\Doctrine\Type\DateBr'
                )
            )
        ),
    ),
);
