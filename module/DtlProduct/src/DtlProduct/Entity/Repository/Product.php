<?php

namespace DtlProduct\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Product extends EntityRepository {

    /**
     * Returns product list filtered by category type
     * 
     * @return entity
     */
    public function findByCategoryType(string $category = '') {
        return $result = $this->_em->getRepository($this->_entityName)
                ->createQueryBuilder('p')
                ->join('p.category', 'c')
                ->where("c.type = '{$category}'")
                ->andWhere('p.isActive = ' . true)
                ->orderBy('p.name', 'ASC')
                ->getQuery()
                ->getResult();
    }

}