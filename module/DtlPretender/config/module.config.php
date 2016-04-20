<?php

namespace DtlPretender;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlPretender\Controller\Pretender' => 'DtlPretender\Factory\Pretender',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlpretender' => array(
                        'type' => 'Segment',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/pretender[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlPretender\Controller',
                                'controller' => 'Pretender',
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
            'DtlPretender' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlpretender' => array(
                        'label' => 'Interessados',
                        'route' => 'dtladmin/dtlpretender',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Interessado',
                                'route' => 'dtladmin/dtlpretender/add',
                            ),
                            'edit' => array(
                                'label' => 'Editar Interessado',
                                'route' => 'dtladmin/dtlpretender/edit',
                            ),
                            'delete' => array(
                                'label' => 'Apagar Interessado',
                                'route' => 'dtladmin/dtlpretender/delete',
                            ),
                            'view' => array(
                                'label' => 'Detalhes do Interessado',
                                'route' => 'dtladmin/dtlpretender/view',
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
