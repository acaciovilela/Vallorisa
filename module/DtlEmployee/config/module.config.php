<?php

namespace DtlEmployee;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlEmployee\Controller\Employee' => 'DtlEmployee\Factory\EmployeeFactory',
        ),
    ),
    'controller_plugins' => array(
        'factories' => array(
            'employee' => 'DtlEmployee\Factory\EmployeeControllerPluginFactory'
        ),
    ),
    'form_elements' => array(
        'factories' => array(
            'EmployeeForm' => 'DtlEmployee\Factory\EmployeeFormFactory',
            'EmployeeFieldset' => 'DtlEmployee\Factory\EmployeeFieldsetFactory',
            'EmployeeCommissionFieldset' => 'DtlEmployee\Factory\EmployeeCommissionFieldsetFactory',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'employee' => 'DtlEmployee\Factory\EmployeeViewHelperFactory',
            'checkLaunchedSalary' => 'DtlEmployee\Factory\CheckLaunchedSalaryFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlemployee' => array(
                        'type' => 'Segment',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/employee[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                'controller' => 'DtlEmployee\Controller\Employee',
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
                                        'controller' => 'DtlEmployee\Controller\Employee',
                                        'action' => 'add',
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:id',
                                    'constraints' => array(
                                        'employeeId' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'DtlEmployee\Controller\Employee',
                                        'action' => 'edit',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'delete' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/delete/:id',
                                    'constraints' => array(
                                        'employeeId' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'DtlEmployee\Controller\Employee',
                                        'action' => 'delete',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'view' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/view/:id',
                                    'constraints' => array(
                                        'employeeId' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'DtlEmployee\Controller\Employee',
                                        'action' => 'view',
                                        'id' => 0
                                    ),
                                ),
                            ),
                            'launchsalary' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/launchsalary',
                                    'defaults' => array(
                                        'controller' => 'DtlEmployee\Controller\Employee',
                                        'action' => 'launchsalary',
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
            'employee' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'employee' => array(
                        'label' => 'Funcionários',
                        'route' => 'dtladmin/dtlemployee',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Funcionário',
                                'route' => 'dtladmin/dtlemployee/add',
                            ),
                            'edit' => array(
                                'label' => 'Editar Funcionário',
                                'route' => 'dtladmin/dtlemployee/edit',
                            ),
                            'delete' => array(
                                'label' => 'Apagar Funcionário',
                                'route' => 'dtladmin/dtlemployee/delete',
                            ),
                            'view' => array(
                                'label' => 'Detalhes do Funcionário',
                                'route' => 'dtladmin/dtlemployee/view',
                            ),
                        ),
                    ),
                ),
            )
        )
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
