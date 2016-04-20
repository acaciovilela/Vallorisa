<?php

namespace DtlRealty;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlRealty\Controller\Realty' => 'DtlRealty\Factory\Realty',
            'DtlRealty\Controller\RealtyType' => 'DtlRealty\Factory\RealtyType',
        ),
        'invokables' => array(
            'DtlRealty\Controller\RealtyFeature' => 'DtlRealty\Controller\RealtyFeatureController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlrealty' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/realty[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlRealty\Controller',
                                'controller' => 'Realty',
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
                    'dtlrealtytype' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/realty-type[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlRealty\Controller',
                                'controller' => 'RealtyType',
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
                    'dtlrealtyfeature' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/realty-feature',
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlRealty\Controller',
                                'controller' => 'RealtyFeature',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'calculatearea' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/calculatearea',
                                    'defaults' => array(
                                        'action' => 'calculatearea',
                                    ),
                                ),
                            ),
                            'calculateground' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/calculateground',
                                    'defaults' => array(
                                        'action' => 'calculateground',
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
            'DtlRealty' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlrealty' => array(
                        'label' => 'Imóvels',
                        'route' => 'dtladmin/dtlrealty',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Imóvel',
                                'route' => 'dtladmin/dtlrealty/add'
                            ),
                            'edit' => array(
                                'label' => 'Editar Imóvel',
                                'route' => 'dtladmin/dtlrealty/edit'
                            ),
                            'delete' => array(
                                'label' => 'Apagar Imóvel',
                                'route' => 'dtladmin/dtlrealty/delete'
                            ),
                        ),
                    ),
                    'realty-type' => array(
                        'label' => 'Tipos de Imóvel',
                        'route' => 'dtladmin/dtlrealtytype',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Tipo de Imóvel',
                                'route' => 'dtladmin/dtlrealtytype/add'
                            ),
                            'edit' => array(
                                'label' => 'Editar Tipo de Imóvel',
                                'route' => 'dtladmin/dtlrealtytype/edit'
                            ),
                            'delete' => array(
                                'label' => 'Apagar Tipo de Imóvel',
                                'route' => 'dtladmin/dtlrealtytype/delete'
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
