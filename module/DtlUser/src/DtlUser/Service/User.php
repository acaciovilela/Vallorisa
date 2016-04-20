<?php

namespace DtlUser\Service;

use ZfcUser\Service\User as ZfcUserService;
use Zend\Crypt\Password\Bcrypt;

class User extends ZfcUserService {

    protected $updateForm;

    public function register(array $data, $user = null) {

        $em = $this->getServiceManager()->get('doctrine.entitymanager.orm_default');

        $bcrypt = new Bcrypt;
        $bcrypt->setCost($this->getOptions()->getPasswordCost());
        $user->setPassword($bcrypt->create($user->getPassword()));

        if ($this->getOptions()->getEnableUsername()) {
            $user->setUsername($data['username']);
        }

        if ($this->getOptions()->getEnableDisplayName()) {
            $user->setDisplayName($data['user']['displayName']);
        }

        // If user state is enabled, set the default state value
        if ($this->getOptions()->getEnableUserState()) {
            if ($this->getOptions()->getDefaultUserState()) {
                $user->setState($this->getOptions()->getDefaultUserState());
            }
        }

        // If this user is a master user so set its ID for other users
        $identity = $this->getServiceManager()->get('zfcuser_auth_service')->getIdentity();
        if (!$identity->getParent()) {
            $parent = $identity;
        } else {
            $parent = $identity->getParent();
        }
        $user->setParent($parent);

        // Set roles to new user being 'user' role as default
        $role = $em->getRepository('\DtlUser\Entity\UserRole')->findOneBy(array('name' => 'user'));
        $user->addRole($role);

        $em->persist($user);

        $em->flush();

        return $user;
    }

    public function update($user) {

        $bcrypt = new Bcrypt();
        $bcrypt->setCost($this->getOptions()->getPasswordCost());
        $password = $bcrypt->create($user->getPassword());
        $user->setPassword($password);
//        \Zend\Debug\Debug::dump($bcrypt->verify($user->getPassword(), $password));exit;

        $em = $this->getServiceManager()->get('doctrine.entitymanager.orm_default');
        $em->persist($user);
        $em->flush();

        return $user;
    }

    /**
     * @return Form
     */
    public function getUpdateForm() {
        if (null === $this->updateForm) {
            $form = $this->getServiceManager()->get('zfcuser_update_form');
            $this->updateForm = $form;
        }
        return $this->updateForm;
    }

}
