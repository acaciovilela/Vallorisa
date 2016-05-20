<?php

namespace DtlRealtor\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Realtor extends EntityRepository {

    public function realtyProposalRealtorList() {
        return $result = $this->_em->getRepository($this->_entityName)
                ->createQueryBuilder('s')
                ->join('s.person', 'p')
                ->where('s.isActive = TRUE')
                ->orderBy('p.name', 'ASC')
                ->getQuery()
                ->getResult();
    }
}