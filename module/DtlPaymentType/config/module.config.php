<?php

namespace DtlPaymentType;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlPaymentType\Controller\PaymentType' => 'DtlPaymentType\Factory\PaymentType',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlpaymenttype' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/payment-type[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlPaymentType\Controller',
                                'controller' => 'PaymentType',
                                'action' => 'index',
                                'page' => 1
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'add' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/add',
                                    'defaults' => array(
                                        'action' => 'add',
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:id',
                                    'constraints' => array(
                                        'id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'action' => 'edit',
                                    ),
                                ),
                            ),
                            'delete' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/delete/:id',
                                    'constraints' => array(
                                        'id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'action' => 'delete',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'dtlpaymenttype' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlpaymenttype' => array(
                        'label' => 'Tipos de Pagamento',
                        'route' => 'dtladmin/dtlpaymenttype',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Tipo de Pagamento',
                                'route' => 'dtladmin/dtlpaymenttype/add'
                            ),
                            'edit' => array(
                                'label' => 'Editar Tipo de Pagamento',
                                'route' => 'dtladmin/dtlpaymenttype/edit'
                            ),
                            'delete' => array(
                                'label' => 'Apagar Tipo de Pagamento',
                                'route' => 'dtladmin/dtlpaymenttype/delete'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'zfc_rbac' => array(
        'guards' => array(
            'ZfcRbac\Guard\RouteGuard' => array(
                'payment-type*' => ['admin'],
            ),
        ),
    ),
);
