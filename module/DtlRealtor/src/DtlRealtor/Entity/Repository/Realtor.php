<?php

namespace DtlRealtor\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Realtor extends EntityRepository {

    public function realtyProposalRealtorList($user) {
        return $result = $this->_em->getRepository($this->_entityName)
                ->createQueryBuilder('s')
                ->join('s.person', 'p')
                ->where('s.user = ' . $user)
                ->andWhere('s.isActive = TRUE')
                ->orderBy('p.name', 'ASC')
                ->getQuery()
                ->getResult();
    }
}