<?php

namespace DtlEmployee\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Employee extends AbstractHelper {

    protected $authService;
    protected $entityManager;
    protected $entity;

    public function __invoke() {

        $identity = $this->getAuthService()->getIdentity();

        $entityManager = $this->getEntityManager();

        $employee = $entityManager->getRepository('DtlEmployee\Entity\Employee')->findOneBy(array(
            'user' => $identity->getId()
        ));

        if ($employee) {
            return $employee;
        }

        return null;
    }

    public function getAuthService() {
        return $this->authService;
    }

    public function setAuthService($authService) {
        $this->authService = $authService;
        return $this;
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    public function getEntity() {
        return $this->entity;
    }

    public function setEntity($entity) {
        $this->entity = $entity;
        return $this;
    }

}
