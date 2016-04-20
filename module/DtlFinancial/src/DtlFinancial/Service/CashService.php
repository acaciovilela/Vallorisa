<?php

namespace DtlFinancial\Service;

class CashService {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $revenue;

    /**
     * @var string
     */
    protected $expense;

    public function filter($post, $user = 0) {
        $where = null;

        if ($post->date) {
            $filter = new \DtlBase\Filter\Date();
            $date = $filter->filter($post->date);
            $where = "AND l.date = '{$date}'";
        }

        $expenses = $this->getEntityManager()
                        ->createQuery(
                                "SELECT e,l FROM {$this->getExpense()} e
                        JOIN e.launch l 
                        WHERE e.user = {$user}
                        {$where}
                        ORDER BY l.date DESC"
                        )->getResult();

        $revenues = $this->getEntityManager()
                        ->createQuery(
                                "SELECT e,l FROM {$this->getRevenue()} e
                        JOIN e.launch l 
                        WHERE e.user = {$user}
                        {$where}
                        ORDER BY l.date DESC"
                        )->getResult();
        return array(
            'expenses' => $expenses,
            'revenues' => $revenues
        );
    }

    public function getExpenses($user = 0, $date = null) {
        return $this->getEntityManager()
                        ->getRepository($this->getExpense())
                        ->getExpenses($user, $date);
    }

    public function getRevenues($user = 0, $date = null) {
        return $this->getEntityManager()
                        ->getRepository($this->getRevenue())
                        ->getRevenues($user, $date);
    }

    public function getLastRevenues($user = 0, $limit = 5) {
        return $this->getEntityManager()
                        ->getRepository($this->getRevenue())
                        ->findBy(array('user' => $user), array('id' => 'DESC'), $limit);
    }

    public function getLastExpenses($user = 0, $limit = 5) {
        return $this->getEntityManager()
                        ->getRepository($this->getExpense())
                        ->findBy(array('user' => $user), array('id' => 'DESC'), $limit);
    }

    public function getExpenseTotal($user = 0, $date = null) {
        return $this->getEntityManager()
                        ->getRepository($this->getExpense())
                        ->getExpenseTotal($user, $date);
    }

    public function getExpenseLastTotal($user = 0, $date = null) {
        return $this->getEntityManager()
                        ->getRepository($this->getExpense())
                        ->getExpenseLastTotal($user, $date);
    }

    public function getRevenueTotal($user = 0, $date = null) {
        return $this->getEntityManager()
                        ->getRepository($this->getRevenue())
                        ->getRevenueTotal($user, $date);
    }

    public function getRevenueLastTotal($user = 0, $date = null) {
        return $this->getEntityManager()
                        ->getRepository($this->getRevenue())
                        ->getRevenueLastTotal($user, $date);
    }

    public function getBalance($user = 0, $date = null) {
        $expenseTotal = $this->getExpenseTotal($user, $date);
        $revenueTotal = $this->getRevenueTotal($user, $date);
        return $revenueTotal['total'] - $expenseTotal['total'];
    }

    public function getLastBalance($user = 0, $date = null) {
        $expenseTotal = $this->getExpenseLastTotal($user, $date);
        $revenueTotal = $this->getRevenueLastTotal($user, $date);
        return $revenueTotal['total'] - $expenseTotal['total'];
    }

    public function getCurrentMonthRevenues($user) {
        $startDate = date('Y-m') . '-01';
        $endDate = date('Y-m-') . date('t', mktime(0, 0, 0, date('m'), '01', date('Y')));
        $revenues = $this->getEntityManager()
                ->getRepository($this->getRevenue())
                ->createQueryBuilder('r')
                ->select('SUM(l.value) as total')
                ->join('r.launch', 'l')
                ->where("l.date BETWEEN '{$startDate}' AND '{$endDate}'")
                ->andWhere("r.user = {$user}")
                ->getQuery()
                ->getSingleResult();

        return $revenues['total'];
    }

    public function getCurrentMonthExpenses($user = 0) {
        $startDate = date('Y-m') . '-01';
        $endDate = date('Y-m-') . date('t', mktime(0, 0, 0, date('m'), '01', date('Y')));
        $expenses = $this->getEntityManager()
                ->getRepository($this->getExpense())
                ->createQueryBuilder('r')
                ->select('SUM(l.value) as total')
                ->join('r.launch', 'l')
                ->where("l.date BETWEEN '{$startDate}' AND '{$endDate}'")
                ->andWhere("r.user = {$user}")
                ->getQuery()
                ->getSingleResult();

        return $expenses['total'];
    }

    public function getCash($date = null) {
        if ($date) {
            $date = $date;
        } else {
            $timestamp = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $date = date('Y-m-d', $timestamp);
        }
        return $this->getEntityManager()
                        ->getRepository('\DtlFinancial\Entity\Launch')
                        ->createQueryBuilder('l')
                        ->orderBy('l.id', 'DESC')
                        ->where("l.date = '" . $date . "'")
                        ->getQuery()
                        ->getResult();
    }

    public function getCashResume($date = null) {

        if ($date) {
            $firstDate = $date;
        } else {
            $date = new \DateTime('now');
            $firstDate = date('Y-m-d', mktime(0, 0, 0, date('m', $date->getTimestamp()), 1, date('Y', $date->getTimestamp())));
        }

        return $this->getEntityManager()
                        ->getRepository('\DtlFinancial\Entity\Launch')
                        ->createQueryBuilder('l')
                        ->orderBy('l.id', 'DESC')
                        ->where("l.date BETWEEN '" . $firstDate . "' AND '" . date('Y-m-d') . "'")
                        ->getQuery()
                        ->getResult();
    }

    public function getCashTotal() {
        return $this->getEntityManager()
                        ->getRepository($this->getRepository())
                        ->getCashTotal();
    }

    public function getCashTotalByDate($date = null) {
        return $this->getEntityManager()
                        ->getRepository($this->getRepository())
                        ->getCashTotalByDate($date);
    }

    public function find($id) {
        return $this->getEntityManager()
                        ->find($this->getRepository(), $id);
    }

    public function findAll() {
        return $this->getEntityManager()
                        ->getRepository($this->getRepository())
                        ->findAll();
    }

    public function findOneBy(array $criteria, array $orderBy = null) {
        return $this->getEntityManager()
                        ->getRepository($this->getRepository())
                        ->findOneBy($criteria, $orderBy);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) {
        return $this->getEntityManager()
                        ->getRepository($this->getRepository())
                        ->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return \DtlFinancial\Service\CashService
     */
    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @return string
     */
    public function getRevenue() {
        return $this->revenue;
    }

    /**
     * @param string $revenue
     * @return \DtlFinancial\Service\CashService
     */
    public function setRevenue($revenue) {
        $this->revenue = $revenue;
        return $this;
    }

    /**
     * @return string
     */
    public function getExpense() {
        return $this->expense;
    }

    /**
     * @param string $expense
     * @return \DtlFinancial\Service\CashService
     */
    public function setExpense($expense) {
        $this->expense = $expense;
        return $this;
    }

}
