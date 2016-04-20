<?php

namespace DtlSeller\Controller;

use DtlSeller\Entity\Seller as SellerEntity;
use DtlSeller\Form\Seller as SellerForm;
use Zend\Mvc\Controller\AbstractActionController;

class SellerController extends AbstractActionController {

    protected $repository;
    protected $entityManager;

    public function indexAction() {
        $this->redirect()->toRoute('dtladmin/dtlshopman');
    }

    public function addAction() {
        $personType = $this->params('type', base64_encode(0));
        $shopmanId = $this->params('id', 1);
        $form = new SellerForm($this->getEntityManager());
        $seller = new SellerEntity();
        $seller->getPerson()->setType(base64_decode($personType));
        $form->bind($seller);
        $em = $this->getEntityManager();
        $shopman = $em->find('DtlShopman\Entity\Shopman', $shopmanId);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $shopman->addSeller($seller);
                $em->persist($shopman);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlshopman');
            }
        }
        return array(
            'form' => $form,
            'personType' => $personType,
            'shopmanId' => $shopmanId,
            'shopmanSeller' => $shopman->getSellers(),
        );
    }

    public function editAction() {
        $personType = $this->params('type', base64_encode(0));
        $shopmanId = $this->params('id', 1);
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $item = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlseller/add/' . $personType);
        }
        $form = new SellerForm($this->getEntityManager());
        $form->bind($item);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($item);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlshopman');
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
            'personType' => $personType,
            'shopmanId' => $shopmanId,
        );
    }

    public function deleteAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->layout('layout/blank');
        }
        $em = $this->getEntityManager();
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('dtladmin/dtlshopman');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $seller = $em->find($this->getRepository(), $id);
                $seller->setIsActive(false);
                $em->flush();
            }
            return $this->redirect()->toRoute('dtladmin/dtlshopman');
        }
        return array(
            'id' => $id,
            'seller' => $em->find($this->getRepository(), $id),
        );
    }

    public function viewAction() {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $item = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlshopman');
        }
        return array(
            'id' => $id,
            'seller' => $em->find($this->getRepository(), $id),
        );
    }

    public function getRepository() {
        return $this->repository;
    }

    public function setRepository($repository) {
        $this->repository = $repository;
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }

}
