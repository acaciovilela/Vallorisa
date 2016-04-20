<?php

namespace DtlShopman\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;

class ShopmanProductController extends AbstractActionController {

    protected $entityManager = null;
    protected $repository = null;

    public function indexAction() {
        $shopmanId = $this->params()->fromQuery('shopmanId');
        
        if (!empty($shopmanId)) {
            $em = $this->getEntityManager();
            $shopman = $em->find('DtlShopman\Entity\Shopman', $shopmanId);
            $form = new \DtlShopman\Form\ShopmanProduct($em);
        } else {
            $this->redirect()->toRoute('dtladmin/dtlshopman');
        }
        
        return new ViewModel(array(
            'shopman' => $shopman,
            'form' => $form
        ));
    }

    public function addAction() {
        $em = $this->getEntityManager();
        $shopmanId = $this->params()->fromQuery('shopman');
        $productId = $this->params()->fromQuery('product');
        $shopman = $em->find('DtlShopman\Entity\Shopman', $shopmanId);
        $product = $em->find('DtlProduct\Entity\Product', $productId);
        $shopman->addProduct($product);
        $em->persist($shopman);
        $em->flush();
        return $this->getResponse()->setContent(Json::encode(array('result' => true)));
    }

    public function listAction() {
        $shopmanId = $this->params()->fromQuery('shopman');
        $em = $this->getEntityManager();
        $shopman = $em->find('DtlShopman\Entity\Shopman', $shopmanId);
        $products = $shopman->getProducts();
        return array(
            'shopmanProducts' => $products,
            'shopmanId' => $shopmanId,
        );
    }

    public function deleteAction() {
        $em = $this->getEntityManager();
        $shopmanId = $this->params()->fromQuery('shopmanId', 0);
        $productId = $this->params()->fromQuery('productId', 0);
        $shopman = $em->find('DtlShopman\Entity\Shopman', $shopmanId);
        $product = $em->find('DtlProduct\Entity\Product', $productId);
        $shopman->removeProduct($product);
        $em->persist($shopman);
        $em->flush();
        return $this->getResponse()->setContent(Json::encode(array('result' => true, 'shopmanId' => $shopman->getId())));
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function setRepository($repository) {
        $this->repository = $repository;
    }

    public function shopmanproductAction() {
        return new ViewModel();
    }

}
