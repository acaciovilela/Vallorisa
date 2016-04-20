<?php

namespace DtlFinancial\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Revenue extends EntityRepository {

    public function getPaginationResult($user = 0) {
        return $this->_em->createQuery("
            SELECT e,l FROM {$this->_entityName} e
            JOIN e.launch l
            WHERE e.user = {$user}
            ORDER BY e.id DESC
        ");
    }
    
    public function getRevenues($user = 0, $date = null) {
        $where = null;
        if ($date) {
            $where = "'AND l.date = '{$date}'";
        }
        return $this->_em->createQuery(
                "SELECT e,l FROM $this->_entityName e
                    JOIN e.launch l
                    WHERE e.user = {$user}
                    {$where}
                    ORDER BY r.id DESC
                ")->getResult();
    }

    public function getRevenueTotal($user = 0, $date = null) {
        $where = null;
        if ($date) {
            $where = "AND l.date = '{$date}'";
        }
        $result = $this->_em->createQuery(
                        "SELECT SUM(l.value) total 
                    FROM {$this->_entityName} r 
                    JOIN r.launch l
                    WHERE r.user = {$user}
                    {$where}
                        ORDER BY r.id DESC
                    ")->getResult();
        foreach ($result as &$value) {
            $value = $value;
        }
        return $value;
    }
    
    public function getRevenueLastTotal($user = 0, $date = null) {
        if ($date) {
            $date = $date;
        } else {
            $timestamp = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
            $date = date('Y-m-d', $timestamp);
        }
        $where = null;
        if ($date) {
            $where = "AND l.date BETWEEN '1900-1-1' AND '{$date}'";
        }
        $result = $this->_em->createQuery(
                        "SELECT SUM(l.value) total 
                    FROM {$this->_entityName} r 
                    JOIN r.launch l
                    WHERE r.user = {$user}
                    {$where}
                    ")->getResult();
        foreach ($result as $value) {
            $value = $value;
        }
        return $value;
    }
}