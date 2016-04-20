<?php

namespace DtlLocation;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlLocation\Controller\Country' => 'DtlLocation\Factory\Country',
            'DtlLocation\Controller\State' => 'DtlLocation\Factory\State',
            'DtlLocation\Controller\City' => 'DtlLocation\Factory\City',
            'DtlLocation\Controller\Index' => 'DtlLocation\Factory\Index',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtllocation' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/location',
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlLocation\Controller',
                                'controller' => 'Index',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'country' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/country[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]*'
                                    ),
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlLocation\Controller',
                                        'controller' => 'Country',
                                        'action' => 'index',
                                        'page' => 1,
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
                            'state' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/state[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]*'
                                    ),
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlLocation\Controller',
                                        'controller' => 'State',
                                        'action' => 'index',
                                        'page' => 1,
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
                                    'fill' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/fill',
                                            'defaults' => array(
                                                'action' => 'fill',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'city' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/city[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]*'
                                    ),
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlLocation\Controller',
                                        'controller' => 'City',
                                        'action' => 'index',
                                        'page' => 1,
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
                                    'fill' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/fill',
                                            'defaults' => array(
                                                'action' => 'fill',
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
            'DtlLocation' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtllocation' => array(
                        'label' => 'Localização',
                        'route' => 'dtladmin/dtllocation',
                        'pages' => array(
                            'country' => array(
                                'label' => 'Países',
                                'route' => 'dtladmin/dtllocation/country',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Adicionar País',
                                        'route' => 'dtladmin/dtllocation/country/add'
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar País',
                                        'route' => 'dtladmin/dtllocation/country/edit'
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar País',
                                        'route' => 'dtladmin/dtllocation/country/delete'
                                    ),
                                ),
                            ),
                            'state' => array(
                                'label' => 'Estados',
                                'route' => 'dtladmin/dtllocation/state',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Adicionar Estado',
                                        'route' => 'dtladmin/dtllocation/state/add'
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Estado',
                                        'route' => 'dtladmin/dtllocation/state/edit'
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Estado',
                                        'route' => 'dtladmin/dtllocation/state/delete'
                                    ),
                                ),
                            ),
                            'city' => array(
                                'label' => 'Cidade',
                                'route' => 'dtladmin/dtllocation/city',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Adicionar Cidade',
                                        'route' => 'dtladmin/dtllocation/city/add'
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Cidade',
                                        'route' => 'dtladmin/dtllocation/city/edit'
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Cidade',
                                        'route' => 'dtladmin/dtllocation/city/delete'
                                    ),
                                ),
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
