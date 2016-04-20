<?php

namespace DtlFinancial\Service;

class RevenueService {
    
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;
    
    /**
     * @var string
     */
    protected $repository;
    
    public function getPaginationResult($user = 0) {
        return $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->getPaginationResult($user);
    }
    
    public function getRevenueTotal($user = 0) {
        return $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->getRevenueTotal($user);
    }
    
    public function getRevenueTotalByDate($date = null) {
        return $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->getRevenueTotalByDate($date);
    }
    
    public function find($id) {
        return $this->getEntityManager()
                ->find($this->getRepository(), $id);
    }
    
    public function findAll() {
        return $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->findAll();
    }
    
    public function findOneBy(array $criteria, array $orderBy = null) {
        return $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->findOneBy($criteria, $orderBy);
    }
    
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) {
        return $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->findBy($criteria, $orderBy, $limit, $offset);
    }
    
    /**
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * @param Doctrine\ORM\EntityManager $entityManager
     * @return \DtlFinancial\Service\Revenue
     */
    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @return string
     */
    public function getRepository() {
        if (!isset($this->repository)) {
            $this->setRepository('DtlFinancial\Entity\Revenue');
        }
        return $this->repository;
    }

    /**
     * @param string $repository
     * @return \DtlFinancial\Service\Revenue
     */
    public function setRepository($repository) {
        $this->repository = $repository;
        return $this;
    }
}
