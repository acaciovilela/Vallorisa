<?php

namespace DtlCollections\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $form = new \DtlCollections\Form\Boss($em);
        $boss = new \DtlCollections\Entity\Boss();
        $form->bind($boss);
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $em->persist($boss);
                $em->flush();
                $this->redirect()->toRoute('dtladmin/dtlcollection');
            }
        }
        return new ViewModel(array(
            'boss' => $em->getRepository('DtlCollections\Entity\Boss')->findAll(),
            'form' => $form,
        ));
    }

}
