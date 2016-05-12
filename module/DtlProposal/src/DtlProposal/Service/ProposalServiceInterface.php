<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DtlProposal\Service;

use DtlProposal\Entity\ProposalEntityInterface;
use DtlCustomer\Entity\Customer;

interface ProposalServiceInterface {

    /**
     * 
     * @param ProposalEntityInterface $entity
     */
    public function save(ProposalEntityInterface $entity);

    /**
     * 
     * @param ProposalEntityInterface $entity
     */
    public function update(ProposalEntityInterface $entity);

    /**
     * 
     * @param ProposalEntityInterface $entity
     */
    public function changeStatus(ProposalEntityInterface $entity, $statusPost);

    /**
     * 
     * @param ProposalEntityInterface $entity
     * @param type $bankPost
     */
    public function changeBank(ProposalEntityInterface $entity, $bankPost);

    /**
     * 
     * @param objetc $params
     */
    public function calculate($params);

    /**
     * 
     * @param ProposalEntityInterface $entity
     * @param Customer $customer
     */
    public function populate(ProposalEntityInterface $entity, Customer $customer);
}
