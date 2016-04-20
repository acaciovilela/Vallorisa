<?php

namespace DtlAdmin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction() {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('zfcuser/login');
        }

        $sm = $this->getServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');

        $customer = $em->getRepository('DtlCustomer\Entity\Customer')->findLastCustomers(5);

        $customerCount = $em->getRepository('DtlCustomer\Entity\Customer')->customerCount();

        $proposalCount = $em->getRepository('DtlProposal\Entity\Proposal')->getCount();

        return new ViewModel(array(
            'customer' => $customer,
            'customerCount' => $customerCount,
            'proposalCount' => $proposalCount,
        ));
    }

}
