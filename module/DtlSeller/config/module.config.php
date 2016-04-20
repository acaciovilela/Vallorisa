<?php

namespace DtlSeller;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlSeller\Controller\Seller' => 'DtlSeller\Factory\Seller',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlseller' => array(
                        'type' => 'Segment',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/seller[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlSeller\Controller',
                                'controller' => 'Seller',
                                'action' => 'index',
                                'page' => 1
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'add' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/add/:id/:type',
                                    'constraints' => array(
                                        'type' => '['.base64_encode(0).base64_encode(1).']*',
                                        'id' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'action' => 'add',
                                        'type' => 'MA==',
                                        'id' => 1
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
                                        'type' => 'MA==',
                                        'id' => 1
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
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'DtlSeller' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlseller' => array(
                        'label' => 'Vendedores',
                        'route' => 'dtladmin/dtlseller',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Vendedor',
                                'route' => 'dtladmin/dtlseller/add',
                            ),
                            'edit' => array(
                                'label' => 'Editar Vendedor',
                                'route' => 'dtladmin/dtlseller/edit',
                            ),
                            'delete' => array(
                                'label' => 'Apagar Vendedor',
                                'route' => 'dtladmin/dtlseller/delete',
                            ),
                            'view' => array(
                                'label' => 'Detalhes do Vendedor',
                                'route' => 'dtladmin/dtlseller/view',
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
