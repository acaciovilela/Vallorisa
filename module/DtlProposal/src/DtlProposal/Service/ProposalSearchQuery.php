<?php

namespace DtlProposal\Service;

class ProposalSearchQuery {

    protected $entityManager;

    public function __construct() {
        
    }

    public function vehicleProposalSearch($query, $post) {

        $params = $post->search;
        
        if (!empty($params['proposalId'])) {
            $query->andWhere('vp.id = ' . $params['proposalId']);
        }

        if (!empty($params['shopman'])) {
            $query->andWhere('vp.shopman = ' . $params['shopman']);
        }

        if (!empty($params['bank'])) {
            $query->andWhere('p.bank = ' . $params['bank']);
        }

        return $this->search($query, $post);
    }

    public function realtyProposalSearch($query, $post) {

        $params = $post->search;

        if (!empty($params['proposalId'])) {
            $query->andWhere('rp.id = ' . $params['proposalId']);
        }

        if (!empty($params['bank'])) {
            $query->andWhere('p.bank = ' . $params['bank']);
        }

        return $this->search($query, $post);
    }

    public function loanProposalSearch($query, $post) {

        $params = $post->search;

        if (!empty($params['proposalId'])) {
            $query->andWhere('l.id = ' . $params['proposalId']);
        }

        if (!empty($params['shopman'])) {
            $query->andWhere('l.shopman = ' . $params['shopman']);
        }

        if (!empty($params['bank'])) {
            $query->andWhere('p.bank = ' . $params['bank']);
        }

        return $this->search($query, $post);
    }

    public function caixaProposalSearch($query, $post) {

        $params = $post->search;

        if (!empty($params['proposalId'])) {
            $query->andWhere('cx.id = ' . $params['proposalId']);
        }

        return $this->search($query, $post);
    }

    public function search($query, $post) {

        $params = $post->search;

        if (!empty($params['proposalStatus'])) {
            $proposalStatus = $params['proposalStatus'];
            switch ($proposalStatus) {
                case 'CHECKING':
                    $query->andWhere('p.isChecking = TRUE');
                    break;
                case 'APPROVED':
                    $query->andWhere('p.isApproved = TRUE');
                    break;
                case 'CANCELED':
                    $query->andWhere('p.isCanceled = TRUE');
                    break;
                case 'ABORTED':
                    $query->andWhere('p.isAborted = TRUE');
                    break;
                case 'INTEGRATED':
                    $query->andWhere('p.isIntegrated = TRUE');
                    break;
                case 'PENDING':
                    $query->andWhere('p.isPending = TRUE');
                    break;
                case 'REFUSED':
                    $query->andWhere('p.isRefused = TRUE');
                    break;
            }
        }

        if (!empty($params['customerName'])) {
            $query->join('p.customer', 'c');
            $query->join('c.person', 'ps');
            $query->andWhere('ps.name LIKE :name');
            $query->setParameter('name', $params['customerName'] . '%');
        }

        if (!empty($params['proposalDateFrom']) && !empty($params['proposalDateTo'])) {
            $filter = new \DtlBase\Filter\Date();
            $query->andWhere('p.baseDate BETWEEN :datefrom AND :dateto');
            $query->setParameter('datefrom', $filter->filter($params['proposalDateFrom']));
            $query->setParameter('dateto', $filter->filter($params['proposalDateTo']));
        }

        if (!empty($params['company'])) {
            $query->andWhere('p.company = ' . $params['company']);
        }

        return $query;
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

}
