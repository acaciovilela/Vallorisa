<?php

namespace DtlFinancial\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController {

    protected $entityManager;

    public function indexAction() {
        
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }
}
