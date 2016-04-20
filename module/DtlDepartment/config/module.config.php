<?php

namespace DtlDepartment;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlDepartment\Controller\Department' => 'DtlDepartment\Factory\Department',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtldepartment' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/department[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlDepartment\Controller',
                                'controller' => 'Department',
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
            'DtlDepartment' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtldepartment' => array(
                        'label' => 'Departamentos',
                        'route' => 'dtladmin/dtldepartment',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Departamento',
                                'route' => 'dtladmin/dtldepartment/add'
                            ),
                            'edit' => array(
                                'label' => 'Editar Departamento',
                                'route' => 'dtladmin/dtldepartment/edit'
                            ),
                            'delete' => array(
                                'label' => 'Apagar Departamento',
                                'route' => 'dtladmin/dtldepartment/delete'
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
