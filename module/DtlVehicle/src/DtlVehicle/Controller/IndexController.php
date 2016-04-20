<?php

namespace DtlVehicle\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;
    
    /**
     * 
     */
    public function indexAction() {}
    
    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return \DtlVehicle\Controller\IndexController
     */
    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

}
