<?php

namespace DtlRealtor;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlRealtor\Controller\Realtor' => 'DtlRealtor\Factory\Realtor',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlrealtor' => array(
                        'type' => 'Segment',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/realtor[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlRealtor\Controller',
                                'controller' => 'Realtor',
                                'action' => 'index',
                                'page' => 1
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'add' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/add/:type',
                                    'constraints' => array(
                                        'type' => '['.base64_encode(0).base64_encode(1).']*',
                                    ),
                                    'defaults' => array(
                                        'action' => 'add',
                                        'type' => 'MA=='
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:id/:type',
                                    'constraints' => array(
                                        'id' => '[0-9]*',
                                        'type' => '['.base64_encode(0).base64_encode(1).']*',
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
                            'view' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/view/:id',
                                    'constraints' => array(
                                        'id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'action' => 'view',
                                    ),
                                ),
                            ),
                            'fill' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/fill',
                                    'defaults' => array(
                                        'action' => 'fill',
                                    ),
                                ),
                            ),
                            'fillproduct' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/fillproduct',
                                    'defaults' => array(
                                        'action' => 'fillproduct',
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
            'DtlRealtor' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlrealtor' => array(
                        'label' => 'Corretor de Imóveis',
                        'route' => 'dtladmin/dtlrealtor',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Corretor de Imóveis',
                                'route' => 'dtladmin/dtlrealtor/add',
                            ),
                            'edit' => array(
                                'label' => 'Editar Corretor de Imóveis',
                                'route' => 'dtladmin/dtlrealtor/edit',
                            ),
                            'delete' => array(
                                'label' => 'Apagar Corretor de Imóveis',
                                'route' => 'dtladmin/dtlrealtor/delete',
                            ),
                            'view' => array(
                                'label' => 'Detalhes do Corretor de Imóveis',
                                'route' => 'dtladmin/dtlrealtor/view',
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
    )
);
