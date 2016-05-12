<?php

namespace DtlBank\View\Helper;

use Zend\View\Helper\AbstractHelper;

class BankName extends AbstractHelper {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function __invoke($bank = null) {

        $bankName = null;

        if (!isset($bank)) {
            $bankName = "BANCO NÃO IDENTIFICADO.";
        }
        
        if (null !== $bank && is_integer((int)$bank)) {
            $em = $this->getEntityManager();    
            $bankEntity = $em->find('\DtlBank\Entity\Bank', $bank);
            $bankName = $bankEntity->getName();
        }
        
        if ($bank instanceof DtlBank\Entity\Bank) {
            $bankName = $bank->getName();
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
