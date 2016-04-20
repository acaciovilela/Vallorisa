<?php

namespace DtlEmployee\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Employee extends EntityRepository {

    public function employeeList($user) {
        $result = $this->_em->createQuery(
                "SELECT e,p FROM {$this->_entityName} e 
                    JOIN e.person p 
                    WHERE e.user = {$user}
                    ORDER BY p.name")
                        ->getResult();
        return $result;
    }

    public function checkLaunchedSalary($employeeId = null) {
        if (!isset($employeeId)) {
            return null;
        }
        $employee = $this->_em->find($this->_entityName, $employeeId);
        $payments = $employee->getPayments();
        if (count($payments)) {
            foreach ($payments as $payment) {
                $paymentDate = $payment->getAccount()->getDatetime();
                $startDate = new \DateTime(date('Y-m') . "-01");
                $endDate = new \DateTime("now");
                if (($paymentDate->getTimestamp() >= $startDate->getTimestamp()) 
                        && ($paymentDate->getTimestamp() <= $endDate->getTimestamp())) {
                    return true;
                }
            }
        }
        
        return false;
    }
}