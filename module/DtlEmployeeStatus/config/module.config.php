<?php

namespace DtlEmployeeStatus;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlEmployeeStatus\Controller\EmployeeStatus' => 'DtlEmployeeStatus\Factory\EmployeeStatus',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlemployeestatus' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/employeestatus[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlEmployeeStatus\Controller',
                                'controller' => 'EmployeeStatus',
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
            'DtlEmployeeStatus' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlemployeestatus' => array(
                        'label' => 'Situações do Funcionário',
                        'route' => 'dtladmin/dtlemployeestatus',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Nova Situação do Funcionário',
                                'route' => 'dtladmin/dtlemployeestatus/add'
                            ),
                            'edit' => array(
                                'label' => 'Editar Situação do Funcionário',
                                'route' => 'dtladmin/dtlemployeestatus/edit'
                            ),
                            'delete' => array(
                                'label' => 'Apagar Situação do Funcionário',
                                'route' => 'dtladmin/dtlemployeestatus/delete'
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
