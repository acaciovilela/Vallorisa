<?php

namespace DtlReport;

return array(
    'controllers' => array(
        'invokables' => array(
            'DtlReport\Controller\Index' => 'DtlReport\Controller\IndexController',
            'DtlReport\Controller\Caixa' => 'DtlReport\Controller\CaixaController'
        ),
        'factories' => array(
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlreport' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/report',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlReport\Controller',
                                'controller' => 'Index',
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
                            'caixa' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/caixa',
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlReport\Controller',
                                        'controller' => 'Caixa',
                                        'action' => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'productsByDate' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/productsByDate',
                                            'defaults' => array(
                                                'action' => 'productsByDate',
                                            ),
                                        ),
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
            'report' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlreport' => array(
                        'label' => 'Relatórios',
                        'route' => 'dtladmin/dtlreport',
                        'pages' => array(
                            'caixa' => array(
                                'label' => 'Módulo Caixa',
                                'route' => 'dtladmin/dtlreport/caixa',
                                'pages' => array(
                                    'productsByDate' => array(
                                        'label' => 'Produtos Por Data',
                                        'route' => 'dtladmin/dtlreport/caixa/productsByDate'
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
