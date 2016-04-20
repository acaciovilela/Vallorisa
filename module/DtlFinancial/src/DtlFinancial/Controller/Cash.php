<?php

namespace DtlFinancial\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class Cash extends AbstractActionController {

    protected $service;
    protected $entityManager;

    public function indexAction() {
        $date = date('Y-m-d');
        if ($this->params()->fromQuery('dt')) {
            $filter = new \DtlBase\Filter\Date();
            $date = $filter->filter($this->params()->fromQuery('dt'));
        }
        $user = $this->dtlUserMasterIdentity()->getId();
        $monthRevenues = $this->getService()->getCurrentMonthRevenues($user, $date);
        $monthExpenses = $this->getService()->getCurrentMonthExpenses($user, $date);
        $expense = $this->getService()->getExpenseTotal($user, $date);
        $revenue = $this->getService()->getRevenueTotal($user, $date);
        $lastBalance = $this->getService()->getLastBalance($user);
        $balance = $this->getService()->getBalance($user, $date) + $lastBalance;
        $cash = $this->getService()->getCash($date);
        $cashResume = $this->getService()->getCashResume($date);
        return array(
            'monthRevenues' => $monthRevenues,
            'monthExpenses' => $monthExpenses,
            'revenue' => $revenue['total'],
            'expense' => $expense['total'],
            'balance' => $balance,
            'lastBalance' => $lastBalance,
            'cash' => $cash,
            'resume' => $cashResume,
            'date' => $date
        );
    }

    public function monthlycashresumeAction() {
        $user = $this->userAuth()->getId();
        $monthRevenues = $this->getService()->getCurrentMonthRevenues($user);
        $monthExpenses = $this->getService()->getCurrentMonthExpenses($user);
        $expense = $this->getService()->getExpenseTotal($user, date('Y-m-d'));
        $revenue = $this->getService()->getRevenueTotal($user, date('Y-m-d'));
        $lastBalance = $this->getService()->getLastBalance($user);
        $balance = $this->getService()->getBalance($user, date('Y-m-d')) + $lastBalance;
        $cash = $this->getService()->getCashResume();
        return array(
            'monthRevenues' => $monthRevenues,
            'monthExpenses' => $monthExpenses,
            'revenue' => $revenue['total'],
            'expense' => $expense['total'],
            'balance' => $balance,
            'lastBalance' => $lastBalance,
            'cash' => $cash,
        );
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function getService() {
        return $this->service;
    }

    public function setService($service) {
        $this->service = $service;
    }

}
