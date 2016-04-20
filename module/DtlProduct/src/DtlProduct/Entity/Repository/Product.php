<?php

namespace DtlProduct\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class Product extends EntityRepository {

    /**
     * Returns product list filtered by category type
     * 
     * @return entity
     */
    public function productList($categoryType = 'VEHICLE_CATEGORY') {
        return $result = $this->_em->getRepository($this->_entityName)
                ->createQueryBuilder('p')
                ->join('p.category', 'c')
                ->where("c.type = '{$categoryType}'")
                ->orderBy('p.name', 'ASC')
                ->getQuery()
                ->getResult();
    }

}