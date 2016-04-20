<?php

namespace DtlSupplier\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Supplier extends EntityRepository {

    public function supplierList($user) {
        $result = $this->_em->createQuery(
                "SELECT s,p 
                    FROM {$this->_entityName} s 
                        JOIN s.person p 
                    WHERE s.user = {$user}
                        ORDER BY p.name")
                        ->getResult();
        return $result;
    }

}