<?php

namespace DtlSupplier;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlSupplier\Controller\Supplier' => 'DtlSupplier\Factory\Supplier',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlsupplier' => array(
                        'type' => 'Segment',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/supplier[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlSupplier\Controller',
                                'controller' => 'Supplier',
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
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'DtlSupplier' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlsupplier' => array(
                        'label' => 'Fornecedores',
                        'route' => 'dtladmin/dtlsupplier',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Fornecedor',
                                'route' => 'dtladmin/dtlsupplier/add',
                            ),
                            'edit' => array(
                                'label' => 'Editar Fornecedor',
                                'route' => 'dtladmin/dtlsupplier/edit',
                            ),
                            'delete' => array(
                                'label' => 'Apagar Fornecedor',
                                'route' => 'dtladmin/dtlsupplier/delete',
                            ),
                            'view' => array(
                                'label' => 'Detalhes do Fornecedor',
                                'route' => 'dtladmin/dtlsupplier/view',
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
