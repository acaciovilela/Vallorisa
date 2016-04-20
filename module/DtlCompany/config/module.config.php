<?php

namespace DtlCompany;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlCompany\Controller\Company' => 'DtlCompany\Factory\CompanyControllerFactory',
        )
    ),
    'service_manager' => array(
        'invokables' => array(
            'zfcuser_user_service' => 'ZfcUser\Service\User',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlcompany' => array(
                        'type' => 'Segment',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/company[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlCompany\Controller',
                                'controller' => 'Company',
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
            'DtlCompany' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'company' => array(
                        'label' => 'Empresas',
                        'route' => 'dtladmin/dtlcompany',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Nova Empresa',
                                'route' => 'dtladmin/dtlcompany/add',
                            ),
                            'edit' => array(
                                'label' => 'Editar Empresa',
                                'route' => 'dtladmin/dtlcompany/edit',
                            ),
                            'delete' => array(
                                'label' => 'Apagar Empresa',
                                'route' => 'dtladmin/dtlcompany/delete',
                            ),
                            'view' => array(
                                'label' => 'Detalhes da Empresa',
                                'route' => 'dtladmin/dtlcompany/view',
                            ),
                        )
                    )
                )
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
