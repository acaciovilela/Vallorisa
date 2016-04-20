<?php

namespace DtlProposal\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Proposal extends EntityRepository {

    public function proposalList($company) {
        $result = $this->_em->createQuery(
                        "SELECT c,p 
                            FROM {$this->_entityName} c 
                                JOIN c.person p 
                            WHERE c.company = {$company}
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
    public function getCount() {
        $result = $this->_em->getRepository($this->_entityName)
                ->createQueryBuilder('p')
                ->select('COUNT(p.id) AS total_proposal_count')
                ->getQuery()
                ->getSingleResult();
        return $result['total_proposal_count'];
    }

    /**
     * Returns count of rows in table
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
