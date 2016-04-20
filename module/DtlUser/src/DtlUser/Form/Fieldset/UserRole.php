<?php

namespace DtlRole\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlRole\Entity\UserRole as UserRoleEntity;

class UserRole extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('userRole');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new UserRoleEntity());

        
    }

    public function getInputFilterSpecification() {
        return array(
            'name' => array(
                'required' => true,
            ),
        );
    }
}
