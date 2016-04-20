<?php

namespace DtlOffice;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlOffice\Controller\Office' => 'DtlOffice\Factory\Office',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtloffice' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/office[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlOffice\Controller',
                                'controller' => 'Office',
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
            'dtloffice' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Dashboard',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtloffice' => array(
                        'label' => 'Cargos',
                        'route' => 'dtladmin/dtloffice',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Cargo',
                                'route' => 'dtladmin/dtloffice/add',
                            ),
                            'edit' => array(
                                'label' => 'Editar Cargo',
                                'route' => 'dtladmin/dtloffice/edit',
                            ),
                            'delete' => array(
                                'label' => 'Apagar Cargo',
                                'route' => 'dtladmin/dtloffice/delete',
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
                'office*' => ['boss'],
            ),
        ),
    ),
);
