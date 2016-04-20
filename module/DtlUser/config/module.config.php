<?php

namespace DtlUser;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlUser\Controller\User' => 'DtlUser\Factory\UserControllerFactory',
        ),
    ),
    'controller_plugins' => array(
        'factories' => array(
            'dtlUserMasterIdentity' => 'DtlUser\Factory\MasterIdentityPluginFactory',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'DtlUser\Entity' => 'zfcuser_entity',
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ),
            ),
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'DtlUser\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
            ),
        ),
    ),
    'service_manager' => array(
        'aliases' => array(
            'Zend\Authentication\AuthenticationService' => 'zfcuser_auth_service'
        ),
        'factories' => array(
            'DtlUser\View\Strategy\RedirectStrategy' => 'DtlUser\Factory\RedirectStrategyFactory',
        ),
    ),
    'zfcuser' => array(
        'user_entity_class' => 'DtlUser\Entity\User',
        'enable_default_entities' => false,
        'enable_registration' => false,
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            "dtluser" => __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'dtlUserMasterIdentity' => 'DtlUser\Factory\MasterIdentityFactory',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtluser' => array(
                        'type' => 'Segment',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/users[/:page]',
                            'contraints' => array(
                                'page' => '[0-9]*',
                            ),
                            'defaults' => array(
                                'controller' => 'DtlUser\Controller\User',
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
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'zfcuser' => array(
                        'label' => 'Perfil do Usuário',
                        'route' => 'dtladmin/zfcuser',
                    ),
                    'dtluser' => array(
                        'label' => 'Usuários',
                        'route' => 'dtladmin/dtluser',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Usuário',
                                'route' => 'dtladmin/dtluser/add',
                            ),
                            'edit' => array(
                                'label' => 'Editar Usuário',
                                'route' => 'dtladmin/dtluser/edit',
                            ),
                            'delete' => array(
                                'label' => 'Apagar Usuário',
                                'route' => 'dtladmin/dtluser/delete',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'zfc_rbac' => array(
        'guards' => array(
            'ZfcRbac\Guard\RouteGuard' => array(
                'dtluser*' => ['dtladmin'],
            ),
        ),
    ),
);
