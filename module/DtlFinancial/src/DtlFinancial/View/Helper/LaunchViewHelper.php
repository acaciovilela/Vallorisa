<?php

namespace DtlFinancial\View\Helper;

use Zend\View\Helper\AbstractHelper;

class LaunchViewHelper extends AbstractHelper {

    protected $entityManager;
    protected $entity;

    public function __invoke($launch = null) {
        $result = null;
        if ($launch) {
            $isRevenue = $this->getEntityManager()
                    ->getRepository('DtlFinancial\Entity\Revenue')
                    ->createQueryBuilder('r')
                    ->where("r.launch = {$launch}")
                    ->getQuery()
                    ->getOneOrNullResult();
            $result = $isRevenue;
            if (!$isRevenue) {
                $isExpense = $this->getEntityManager()
                        ->getRepository('DtlFinancial\Entity\Expense')
                        ->createQueryBuilder('e')
                        ->where("e.launch = {$launch}")
                        ->getQuery()
                        ->getOneOrNullResult();
                $result = $isExpense;
            }
            return $result;
        }
        return false;
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * 
     * @return \DtlFinancial\Entity\Launch
     */
    public function getEntity() {
        return $this->entity;
    }

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * 
     * @param \DtlFinancial\Entity\Launch $entity
     */
    public function setEntity($entity) {
        $this->entity = $entity;
    }

}
