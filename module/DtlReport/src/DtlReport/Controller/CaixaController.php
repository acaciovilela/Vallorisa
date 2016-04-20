<?php

namespace DtlReport\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CaixaController extends AbstractActionController {

    public function indexAction() {
        return new ViewModel();
    }

    public function productsByDateAction() {
        
        $sm = $this->getServiceLocator();
        $em = $sm->get('doctrine.entitymanager.orm_default');
        
        $form = new \DtlReport\Form\ProductsByDate($em);
        
        $query = $em->getRepository('Proposal\Entity\CaixaProposal')
                ->createQueryBuilder('cp')
//                ->select('cp.caixaProposalId')
                ->join('cp.products', 'p')
                ->getQuery();
        
        if ($this->request->isPost()) {
            if ($form->isValid()) {
                
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
            'result' => $query->getResult(),
        ));
    }
}
