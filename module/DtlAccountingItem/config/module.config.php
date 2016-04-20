<?php

namespace DtlAccountingItem;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlAccountingItem\Controller\AccountingItem' => 'DtlAccountingItem\Factory\AccountingItem',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlaccountingitem' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/accounting-item[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlAccountingItem\Controller',
                                'controller' => 'AccountingItem',
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
            'DtlAccountingItem' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlaccountingitem' => array(
                        'label' => 'Item Contábil',
                        'route' => 'dtladmin/dtlaccountingitem',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Item Contábil',
                                'route' => 'dtladmin/dtlaccountingitem/add'
                            ),
                            'edit' => array(
                                'label' => 'Editar Item Contábil',
                                'route' => 'dtladmin/dtlaccountingitem/edit'
                            ),
                            'delete' => array(
                                'label' => 'Apagar Item Contábil',
                                'route' => 'dtladmin/dtlaccountingitem/delete'
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
                'dtlaccountingitem*' => ['admin'],
            ),
        ),
    ),
);
