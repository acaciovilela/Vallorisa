<?php

namespace DtlFile;

return array(
    'controllers' => array(
        'factories' => array(
            'DtlFile\Controller\File' => 'DtlFile\Factory\FileFactory',
        )
    ),
    'router' => array(
        'routes' => array(
            'dtladmin' => array(
                'child_routes' => array(
                    'dtlfile' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/file',
                            'defaults' => array(
                                '__NAMESPACE__' => 'DtlFile\Controller',
                                'controller' => 'File',
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
                                        'id' => 1,
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
            'DtlFile' => __DIR__ . '/../view',
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
