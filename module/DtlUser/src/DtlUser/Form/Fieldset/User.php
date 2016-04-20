<?php

namespace DtlUser\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlUser\Entity\User as UserEntity;

class User extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        parent::__construct('user');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new UserEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'attributes' => array(
                'placeholder'   => 'Email',
                'class'         => 'form-control',
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Email'
            )
        ));
        
        $this->add(array(
            'name' => 'username',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Usuário',
                'class'         => 'form-control',
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Usuário'
            )
        ));
        
        $this->add(array(
            'name' => 'displayName',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder'   => 'Nome',
                'class'         => 'form-control',
                'required'      => 'required',
            ),
            'options' => array(
                'label' => 'Nome'
            )
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'placeholder'   => 'Senha',
                'class'         => 'form-control',
                'required'      => 'required',
                'autocomplete'  => 'off',
            ),
            'options' => array(
                'label' => 'Senha'
            )
        ));
        
        $this->add(array(
            'name' => 'passwordVerify',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'placeholder'   => 'Confirmação de Senha',
                'class'         => 'form-control',
                'required'      => 'required',
                'autocomplete'  => 'off',
            ),
            'options' => array(
                'label' => 'Confirmação de Senha'
            )
        ));
        
        $userProfile = new \DtlUser\Form\Fieldset\UserProfile($entityManager);
        $userProfile->setName('profile');
        $this->add($userProfile);
    }

    public function getInputFilterSpecification() {
        return array(
            'email' => array(
                'required' => true,
                'validators' => array(
                    new \Zend\Validator\EmailAddress(),
                ),
            ),
            'username' => array(
                'required' => true,
                'filters' => array(
                    new \Zend\Filter\StringToUpper(),
                ),
            ),
            'displayName' => array(
                'required' => true,
                'filters' => array(
                    new \Zend\Filter\StringTrim(),
                ),
                'validators' => array(
                    new \Zend\Validator\StringLength(array(
                        'min' => 3,
                        'max' => 255
                    )),
                ),
            ),
            'password' => array(
                'required' => true,
                'filters' => array(
                    new \Zend\Filter\StringTrim(),
                ),
                'validators' => array(
                    new \Zend\Validator\StringLength(array(
                        'min' => 6,
                    )),
                ),
            ),
            'passwordVerify' => array(
                'required' => true,
                'filters' => array(
                    new \Zend\Filter\StringTrim(),
                ),
                'validators' => array(
                    new \Zend\Validator\StringLength(array(
                        'min' => 6,
                    )),
                    new \Zend\Validator\Identical(array(
                        'token' => 'password',
                    )),
                ),
            ),
        );
    }
}
