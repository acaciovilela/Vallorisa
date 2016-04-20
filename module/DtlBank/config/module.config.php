<?php

namespace DtlBank;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlBank\Controller\Bank' => 'DtlBank\Factory\BankFactory',
        )
    ),
    'view_helpers' => array(
        'factories' => array(
            'bankName' => 'DtlBank\Factory\BankNameFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlbank' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/bank[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlBank\Controller',
                                'controller' => 'Bank',
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
                                        'id' => 1,
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
            'DtlBank' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlbank' => array(
                        'label' => 'Bancos',
                        'route' => 'dtladmin/dtlbank',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Banco',
                                'route' => 'dtladmin/dtlbank/add',
                            ),
                            'edit' => array(
                                'label' => 'Editar Banco',
                                'route' => 'dtladmin/dtlbank/edit',
                            ),
                            'delete' => array(
                                'label' => 'Apagar Banco',
                                'route' => 'dtladmin/dtlbank/delete',
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
                'dtlbank*' => ['boss'],
            ),
        ),
    ),
);
