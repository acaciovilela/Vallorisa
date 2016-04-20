<?php

namespace DtlProduct;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlProduct\Controller\Category' => 'DtlProduct\Factory\Category',
            'DtlProduct\Controller\Product' => 'DtlProduct\Factory\Product',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlcategory' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/category[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlProduct\Controller',
                                'controller' => 'Category',
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
                            'list' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/list',
                                    'defaults' => array(
                                        'action' => 'list',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'dtlproduct' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/product[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlProduct\Controller',
                                'controller' => 'Product',
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
            'DtlProduct' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'category' => array(
                        'label' => 'Categorias',
                        'route' => 'dtladmin/dtlcategory',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Nova Categoria',
                                'route' => 'dtladmin/dtlcategory/add'
                            ),
                            'edit' => array(
                                'label' => 'Editar Categoria',
                                'route' => 'dtladmin/dtlcategory/edit'
                            ),
                            'delete' => array(
                                'label' => 'Apagar Categoria',
                                'route' => 'dtladmin/dtlcategory/delete'
                            ),
                        ),
                    ),
                    'product' => array(
                        'label' => 'Produtos',
                        'route' => 'dtladmin/dtlproduct',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Produto',
                                'route' => 'dtladmin/dtlproduct/add'
                            ),
                            'edit' => array(
                                'label' => 'Editar Produto',
                                'route' => 'dtladmin/dtlproduct/edit'
                            ),
                            'delete' => array(
                                'label' => 'Apagar Produto',
                                'route' => 'dtladmin/dtlproduct/delete'
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
