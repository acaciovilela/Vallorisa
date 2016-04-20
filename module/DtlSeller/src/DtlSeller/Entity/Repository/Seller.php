<?php

namespace DtlSeller\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Seller extends EntityRepository {

    public function sellerList($user) {
        $result = $this->_em->createQuery(
                        "SELECT s,p 
                            FROM {$this->_entityName} s 
                                JOIN s.person p 
                            WHERE s.user = {$user}
                                ORDER BY p.name"
                )
                ->getResult();
        return $result;
    }

}
