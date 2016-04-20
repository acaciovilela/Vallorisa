<?php

namespace DtlShopman;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlShopman\Controller\Shopman' => 'DtlShopman\Factory\Shopman',
            'DtlShopman\Controller\ShopmanProduct' => 'DtlShopman\Factory\ShopmanProduct',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlshopman' => array(
                        'type' => 'Segment',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/shopman[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlShopman\Controller',
                                'controller' => 'Shopman',
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
                                        'type' => '[' . base64_encode(0) . base64_encode(1) . ']*',
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
                                        'type' => '[' . base64_encode(0) . base64_encode(1) . ']*',
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
                            'fill' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/fill',
                                    'defaults' => array(
                                        'action' => 'fill',
                                    ),
                                ),
                            ),
                            'fillproduct' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/fillproduct',
                                    'defaults' => array(
                                        'action' => 'fillproduct',
                                    ),
                                ),
                            ),
                            'shopman-product' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/shopman-product[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]*'
                                    ),
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlShopman\Controller',
                                        'controller' => 'ShopmanProduct',
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
                                    'list' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/list',
                                            'defaults' => array(
                                                'action' => 'list',
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/delete',
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
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Shopman' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlshopman' => array(
                        'label' => 'Lojistas',
                        'route' => 'dtladmin/dtlshopman',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Lojista',
                                'route' => 'dtladmin/dtlshopman/add',
                            ),
                            'edit' => array(
                                'label' => 'Editar Lojista',
                                'route' => 'dtladmin/dtlshopman/edit',
                            ),
                            'delete' => array(
                                'label' => 'Apagar Lojista',
                                'route' => 'dtladmin/dtlshopman/delete',
                            ),
                            'view' => array(
                                'label' => 'Detalhes do Lojista',
                                'route' => 'dtladmin/dtlshopman/view',
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
