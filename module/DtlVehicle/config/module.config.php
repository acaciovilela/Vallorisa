<?php

namespace DtlVehicle;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlVehicle\Controller\Index' => 'DtlVehicle\Factory\Index',
            'DtlVehicle\Controller\VehicleBrand' => 'DtlVehicle\Factory\VehicleBrand',
            'DtlVehicle\Controller\VehicleType' => 'DtlVehicle\Factory\VehicleType',
            'DtlVehicle\Controller\VehicleModel' => 'DtlVehicle\Factory\VehicleModel',
            'DtlVehicle\Controller\VehicleVersion' => 'DtlVehicle\Factory\VehicleVersion',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlvehicle' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/vehicle',
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlVehicle\Controller',
                                'controller' => 'Index',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'vehicle-brand' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/vehicle-brand[/:page]',
                                    'constraints' => array(
                                        'page' => '[0-9]*',
                                    ),
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlVehicle\Controller',
                                        'controller' => 'VehicleBrand',
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
                            'vehicle-type' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/vehicle-type',
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlVehicle\Controller',
                                        'controller' => 'VehicleType',
                                        'action' => 'index',
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
                                    'delete' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/delete',
                                            'defaults' => array(
                                                'action' => 'delete',
                                            ),
                                        ),
                                    ),
                                    'list' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/list/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'list',
                                            ),
                                        ),
                                    ),
                                    'post' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/post',
                                            'defaults' => array(
                                                'action' => 'post',
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
                            'vehicle-model' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/vehicle-model',
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlVehicle\Controller',
                                        'controller' => 'VehicleModel',
                                        'action' => 'index',
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
                                    'delete' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/delete',
                                            'defaults' => array(
                                                'action' => 'delete',
                                            ),
                                        ),
                                    ),
                                    'list' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/list/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'list',
                                            ),
                                        ),
                                    ),
                                    'post' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/post',
                                            'defaults' => array(
                                                'action' => 'post',
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
                            'vehicle-version' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/vehicle-version',
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlVehicle\Controller',
                                        'controller' => 'VehicleVersion',
                                        'action' => 'index',
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
                                    'delete' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/delete',
                                            'defaults' => array(
                                                'action' => 'delete',
                                            ),
                                        ),
                                    ),
                                    'list' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/list/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'list',
                                            ),
                                        ),
                                    ),
                                    'post' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/post',
                                            'defaults' => array(
                                                'action' => 'post',
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
            'DtlVehicle' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlvehicle' => array(
                        'label' => 'Veículos',
                        'route' => 'dtladmin/dtlvehicle',
                        'pages' => array(
                            'vehicle-brand' => array(
                                'label' => 'Marcas',
                                'route' => 'dtladmin/dtlvehicle/vehicle-brand',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Adicionar Marca',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-brand/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Marca',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-brand/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Marca',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-brand/delete',
                                    ),
                                    'view' => array(
                                        'label' => 'Detalhes da Marca',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-brand/view',
                                    ),
                                ),
                            ),
                            'vehicle-type' => array(
                                'label' => 'Tipos de Veículos',
                                'route' => 'dtladmin/dtlvehicle/vehicle-type',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Adicionar Tipo de Veículo',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-type/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Tipo de Veículo',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-type/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Tipo de Veículo',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-type/delete',
                                    ),
                                    'view' => array(
                                        'label' => 'Detalhes do Tipo de Veículo',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-type/view',
                                    ),
                                ),
                            ),
                            'vehicle-model' => array(
                                'label' => 'Tipos de Veículos',
                                'route' => 'dtladmin/dtlvehicle/vehicle-model',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Adicionar Modelo',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-model/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Modelo',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-model/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Modelo',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-model/delete',
                                    ),
                                    'view' => array(
                                        'label' => 'Detalhes do Modelo',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-model/view',
                                    ),
                                ),
                            ),
                            'vehicle-version' => array(
                                'label' => 'Versões de Veículos',
                                'route' => 'dtladmin/dtlvehicle/vehicle-version',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Adicionar Versão',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-version/add',
                                    ),
                                    'edit' => array(
                                        'label' => 'Editar Versão',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-version/edit',
                                    ),
                                    'delete' => array(
                                        'label' => 'Apagar Versão',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-version/delete',
                                    ),
                                    'view' => array(
                                        'label' => 'Detalhes do Versão',
                                        'route' => 'dtladmin/dtlvehicle/vehicle-version/view',
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
