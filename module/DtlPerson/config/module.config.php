<?php

namespace DtlPerson;

return array(
    'view_helpers' => array(
        'invokables' => array(
            'personForm' => 'DtlPerson\Form\View\Helper\PersonForm',
            'addressForm' => 'DtlPerson\Form\View\Helper\AddressForm',
            'contactForm' => 'DtlPerson\Form\View\Helper\ContactForm',
            'individualForm' => 'DtlPerson\Form\View\Helper\IndividualForm',
            'legalForm' => 'DtlPerson\Form\View\Helper\LegalForm',
            'professionalForm' => 'DtlPerson\Form\View\Helper\ProfessionalForm',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'DtlPerson' => __DIR__ . '/../view',
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

