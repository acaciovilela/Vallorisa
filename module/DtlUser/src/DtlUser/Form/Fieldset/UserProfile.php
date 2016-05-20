<?php

namespace DtlUser\Form\Fieldset;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset as ZendFielset;
use DtlUser\Entity\UserProfile as UserProfileEntity;

class UserProfile extends ZendFielset implements InputFilterProviderInterface {

    public function __construct($entityManager) {
        
        parent::__construct('userProfile');
        
        $this->setHydrator(new DoctrineHydrator($entityManager))
                ->setObject(new UserProfileEntity());

        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        $this->add(array(
            'name' => 'lastName',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'placeholder' => 'Sobrenome',
            ),
            'options' => array(
                'label' => 'Sobrenome',
            ),
        ));
        
        $this->add(array(
            'name' => 'about',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'placeholder' => 'Fale sobre você',
            ),
            'options' => array(
                'label' => 'Sobre Você',
            ),
        ));
        
        $this->add(array(
            'name' => 'news',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'value' => 1,
            ),
            'options' => array(
                'label' => 'Eu quero receber notícias.',
            ),
        ));
        
        $address = new \DtlPerson\Form\Fieldset\Address($entityManager);
        $address->setName('address');
        $this->add($address);
        
        $contact = new \DtlPerson\Form\Fieldset\Contact($entityManager);
        $contact->setName('contact');
        $this->add($contact);
    }

    public function getInputFilterSpecification() {
        return array(
            'news' => array(
                'required' => false,
            ),
        );
    }
}
