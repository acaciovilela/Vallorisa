<?php

namespace DtlFinancial\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Receivable extends EntityRepository {

    public function getReceivableTotal() {
        $result = $this->_em->createQuery("SELECT SUM(a.value) total "
                . "FROM {$this->_entityName} r JOIN r.account a "
                . "WHERE (a.done = false)")
                        ->getResult();
        foreach ($result as &$value) {
            $value = $value;
        }
        return $value;
    }

}