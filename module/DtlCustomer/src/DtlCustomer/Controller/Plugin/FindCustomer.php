<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DtlCustomer\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class FindCustomer extends AbstractPlugin {

    protected $entityManager;

    /**
     * 
     * Get a customer by document number CPF | CNPJ
     * 
     * @param string $docNumber
     * @return null|DtlCustomer\Entity\Customer
     */
    public function __invoke($docNumber = null) {

        if (!isset($docNumber)) {
            return null;
        }

        $filter = new \Zend\Filter\Digits();
        $document = $filter->filter($docNumber);
        $em = $this->getEntityManager();

        if (strlen($document) === 11) {
            $customer = $em->getRepository('DtlCustomer\Entity\Customer')
                    ->createQueryBuilder('c')
                    ->Join('c.person', 'p')
                    ->leftJoin('p.individual', 'i')
                    ->where('i.cpf = ' . $document)
                    ->andWhere('c.isActive = true')
                    ->getQuery()
                    ->getOneOrNullResult();
        } elseif (strlen($document) === 14) {
            $customer = $em->getRepository('DtlCustomer\Entity\Customer')
                    ->createQueryBuilder('c')
                    ->Join('c.person', 'p')
                    ->leftJoin('p.legal', 'l')
                    ->where('l.cnpj = ' . $document)
                    ->andWhere('c.isActive = true')
                    ->getQuery()
                    ->getOneOrNullResult();
        } else {
            return null;
        }

        return $customer;
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

}
