<?php

return array(
    'doctrine' => array(
        'driver' => array(
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../src/User/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'User\Entity' => 'zfcuser_entity',
                ),
            ),
        ),
    ),
    'zfcuser' => array(
        'user_entity_class'       => 'User\Entity\User',
        'enable_default_entities' => false,
    ),
    'factories' => array(
        'zfcuser_user_mapper' => function ($sm) {
            return new \ZfcUserDoctrineORM\Mapper\User(
                    $sm->get('doctrine.entitymanager.orm_default'), 
                    $sm->get('zfcuser_module_options')
            );
        },
    ),
//    'bjyauthorize' => array(
//        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
//        'role_providers'        => array(
//            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
//                'object_manager'    => 'doctrine.entitymanager.orm_default',
//                'role_entity_class' => 'User\Entity\Role',
//             ),
//        ),
//    ),
);
