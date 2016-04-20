<?php

namespace DtlProposal\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class CaixaProposal extends EntityRepository {

    /**
     * Returns count of rows in table
     * 
     * @return integer
     */
    public function getCount() {
        $result = $this->_em->getRepository($this->_entityName)
                ->createQueryBuilder('cp')
                ->select('COUNT(cp.id) AS proposal_count')
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
                ->createQueryBuilder('cp')
                ->select(array('pp.name', 'cp.date'))
                ->join('cp.customer', 'c')
                ->join('c.person', 'pp')
                ->orderBy('cp.timestamp', 'DESC')
                ->setMaxResults($limit)
                ->getQuery();
        return $result->getResult();
    }

}