<?php

namespace DtlBank\View\Helper;

use Zend\View\Helper\AbstractHelper;

class BankName extends AbstractHelper {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function __invoke($bankId = null) {

        $em = $this->getEntityManager();

        $bank = $em->find('\DtlBank\Entity\Bank', $bankId);

        if ($bank) {
            $bankName = $bank->getName();
        } else {
            $bankName = "BANCO NÃO IDENTIFICADO";
        }

        return htmlspecialchars($bankName, ENT_QUOTES, 'UTF-8');
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

}
