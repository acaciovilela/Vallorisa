<?php

namespace DtlEmployee\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CheckLaunchedSalary extends AbstractHelper {

    protected $entityManager;

    public function __invoke($employee) {

        $em = $this->getEntityManager();

        $checked = $em->getRepository('DtlEmployee\Entity\Employee')
                ->checkLaunchedSalary($employee);

        return $checked;
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

}
