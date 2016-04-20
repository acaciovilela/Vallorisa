<?php

namespace DtlCustomer\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Customer extends EntityRepository {

    public function customerList($user) {
        $result = $this->_em->createQuery(
                        "SELECT c,p 
                            FROM {$this->_entityName} c 
                                JOIN c.person p 
                            WHERE c.user = {$user}
                                ORDER BY p.name"
                )
                ->getResult();
        return $result;
    }

    /**
     * Returns count of rows in table
     * 
     * @return integer
     */
    public function customerCount() {
        $result = $this->_em->getRepository($this->_entityName)
                ->createQueryBuilder('c')
                ->select('COUNT(c.id) AS customerCount')
                ->where('c.isActive = true')
                ->getQuery()
                ->getSingleResult();
        return $result['customerCount'];
    }

    /**
     * Returns count of rows in table
     * 
     * @return integer
     */
    public function findLastCustomers($limit = 5) {
        $result = $this->_em->getRepository($this->_entityName)
                ->createQueryBuilder('c')
                ->select(array('p.name', 'c.timestamp'))
                ->join('c.person', 'p')
                ->where('c.isActive = true')
                ->orderBy('c.timestamp', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
        return $result;
    }

}