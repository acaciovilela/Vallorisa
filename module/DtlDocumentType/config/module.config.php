<?php

namespace DtlDocumentType;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlDocumentType\Controller\DocumentType' => 'DtlDocumentType\Factory\DocumentType',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtldocumenttype' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/document-type[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]*'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlDocumentType\Controller',
                                'controller' => 'DocumentType',
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
            'dtldocumenttype' => __DIR__ . '/../view',
        ),
    ),
    'navigation' => array(
        'dtladmin' => array(
            'dtladmin' => array(
                'label' => 'Home',
                'route' => 'dtladmin',
                'pages' => array(
                    'dtldocumenttype' => array(
                        'label' => 'Tipos de Documentos',
                        'route' => 'dtladmin/dtldocumenttype',
                        'pages' => array(
                            'add' => array(
                                'label' => 'Novo Tipo de Documento',
                                'route' => 'dtladmin/dtldocumenttype/add'
                            ),
                            'edit' => array(
                                'label' => 'Editar Tipo de Documento',
                                'route' => 'dtladmin/dtldocumenttype/edit'
                            ),
                            'delete' => array(
                                'label' => 'Apagar Tipo de Documento',
                                'route' => 'dtladmin/dtldocumenttype/delete'
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
                'dtldocumenttype*' => ['admin'],
            ),
        ),
    ),
);
