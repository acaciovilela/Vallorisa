<?php

namespace DtlShopman\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Shopman extends EntityRepository {

    public function vehicleProposalShopmanList($user) {
        return $result = $this->_em->getRepository($this->_entityName)
                ->createQueryBuilder('s')
                ->join('s.person', 'p')
                ->where('s.user = ' . $user)
                ->andWhere('s.isActive = TRUE')
                ->orderBy('p.name', 'ASC')
                ->getQuery()
                ->getResult();
    }
    
    public function loanProposalShopmanList($user) {
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