<?php

namespace DtlCompany\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Company extends EntityRepository {

    public function companyList() {
        $result = $this->_em->createQuery(
                        "SELECT c
                        FROM {$this->_entityName} c
                        ORDER BY c.fancyName"
                )
                ->getResult();
        return $result;
    }

}
