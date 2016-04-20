<?php

namespace DtlProposal\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class RealtyProposal extends EntityRepository {

    /**
     * Returns count of rows in table
     * 
     * @return integer
     */
    public function getCount() {
        $result = $this->_em->getRepository($this->_entityName)
                ->createQueryBuilder('r')
                ->select('COUNT(r.id) AS proposal_count')
                ->getQuery()
                ->getSingleResult();
        return $result['proposal_count'];
    }
    
    /**
     * Returns last inserted rows in table
     * 
     * @return integer
     */
    public function findLast($limit = 5) {
        $result = $this->_em->getRepository($this->_entityName)
                ->createQueryBuilder('p')
                ->select(array('pp.name', 'p.date'))
                ->join('p.customer', 'c')
                ->join('c.person', 'pp')
                ->orderBy('p.timestamp', 'DESC')
                ->setMaxResults($limit)
                ->getQuery();
        return $result->getResult();
    }

}