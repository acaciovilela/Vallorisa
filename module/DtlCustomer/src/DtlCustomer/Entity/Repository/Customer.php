<?php

namespace DtlCustomer\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Customer extends EntityRepository {

    public function customerList($user) {
        $result = $this->_em->getRepository($this->_entityName)
                ->createQueryBuilder('c')
                ->join('c.person', 'p')
                ->where('c.isActive = true')
                ->andWhere('c.user = ' . $user)
                ->orderBy('p.name', 'ASC')
                ->getQuery()
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
