<?php

namespace DtlCustomer;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlCustomer\Controller\Customer' => 'DtlCustomer\Factory\Customer',
            'DtlCustomer\Controller\CustomerBankAccount' => 'DtlCustomer\Factory\CustomerBankAccount',
            'DtlCustomer\Controller\CustomerPatrimony' => 'DtlCustomer\Factory\CustomerPatrimony',
            'DtlCustomer\Controller\CustomerReference' => 'DtlCustomer\Factory\CustomerReference',
            'DtlCustomer\Controller\CustomerVehicle' => 'DtlCustomer\Factory\CustomerVehicle',
        )
    ),
    'controller_plugins' => array(
        'factories' => array(
            'findCustomer' => function($sm) {
                $plugin = new Controller\Plugin\FindCustomer();
                $plugin->setEntityManager($sm->getServiceLocator()->get('doctrine.entitymanager.orm_default'));
                return $plugin;
            }
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlcustomer' => array(
                        'type' => 'Segment',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/customer[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlCustomer\Controller',
                                'controller' => 'Customer',
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
                            'exportCsv' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/exportCsv',
                                    'defaults' => array(
                                        'action' => 'exportCsv',
                                    ),
                                ),
                            ),
                            'customer-bank-account' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/customer-bank-account',
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlCustomer\Controller',
                                        'controller' => 'CustomerBankAccount',
                                        'action' => 'index'
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'add' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/add/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'add',
                                                'id' => 1
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
                                                'id' => 1
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
                            'customer-patrimony' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/customer-patrimony',
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlCustomer\Controller',
                                        'controller' => 'CustomerPatrimony',
                                        'action' => 'index'
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'add' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/add/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'add',
                                                'id' => 1
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
                                                'id' => 1
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
                            'customer-reference' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/customer-reference',
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlCustomer\Controller',
                                        'controller' => 'CustomerReference',
                                        'action' => 'index'
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'add' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/add/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'add',
                                                'id' => 1
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
                                                'id' => 1
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
                            'customer-vehicle' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/customer-vehicle',
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'DtlCustomer\Controller',
                                        'controller' => 'CustomerVehicle',
                                        'action' => 'index'
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'add' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/add/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults' => array(
                                                'action' => 'add',
                                                'id' => 1
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
                                                'id' => 1
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
            'DtlCustomer' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtlcustomer' => array(
                        'label' => 'Clientes',
                        'route' => 'dtladmin/dtlcustomer',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Cliente',
                                'route' => 'dtladmin/dtlcustomer/add',
                            ),
                            'edit' => array(
                                'label' => 'Editar Cliente',
                                'route' => 'dtladmin/dtlcustomer/edit',
                            ),
                            'delete' => array(
                                'label' => 'Apagar Cliente',
                                'route' => 'dtladmin/dtlcustomer/delete',
                            ),
                            'view' => array(
                                'label' => 'Detalhes do Cliente',
                                'route' => 'dtladmin/dtlcustomer/view',
                            ),
                            'customer-bank-account' => array(
                                'label' => 'Conta do Cliente',
                                'route' => 'dtladmin/dtlcustomer/customer-bank-account',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Nova Conta',
                                        'route' => 'dtladmin/dtlcustomer/customer-bank-account/add',
                                    ),
                                ),
                            ),
                            'customer-patrimony' => array(
                                'label' => 'Patrimônio',
                                'route' => 'dtladmin/dtlcustomer/customer-patrimony',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Novo Bem',
                                        'route' => 'dtladmin/dtlcustomer/customer-patrimony/add',
                                    ),
                                ),
                            ),
                            'customer-reference' => array(
                                'label' => 'Referências',
                                'route' => 'dtladmin/dtlcustomer/customer-reference',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Nova Referência',
                                        'route' => 'dtladmin/dtlcustomer/customer-reference/add',
                                    ),
                                ),
                            ),
                            'customer-vehicle' => array(
                                'label' => 'Veículos do Cliente',
                                'route' => 'dtladmin/dtlcustomer/customer-vehicle',
                                'pages' => array(
                                    'add' => array(
                                        'label' => 'Novo Veículo',
                                        'route' => 'dtladmin/dtlcustomer/customer-vehicle/add',
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
