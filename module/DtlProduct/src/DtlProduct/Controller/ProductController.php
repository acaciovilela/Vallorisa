<?php

namespace DtlProduct\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlProduct\Form\Product as ProductForm;
use DtlProduct\Entity\Product as ProductEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class ProductController extends AbstractActionController {

    /**
     * @var DtlProduct\Entity\ProductEntity
     */
    protected $repository;

    /**
     * @
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function indexAction() {

        $query = $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->createQueryBuilder('p')
                ->where('p.user = ' . $this->dtlUserMasterIdentity()->getId())
                ->orderBy('p.name', 'ASC');

        if ($this->request->isPost()) {
            $formSearch = $this->getRequest()->getPost();
            if (!empty($formSearch->product_cod_search)) {
                $query->andWhere("p.id = :cod");
                $query->setParameter('cod', $formSearch->product_cod_search);
            } elseif (!empty($formSearch->product_name_search)) {
                $query->andWhere("p.name LIKE :name");
                $query->setParameter('name', '%' . $formSearch->product_name_search . '%');
            }
        }

        $adapter = new DoctrineAdapter(new DoctrinePaginator($query));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);

        $page = $this->params()->fromRoute('page');

        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return array(
            'product' => $paginator,
            'entityManager' => $this->getEntityManager(),
        );
    }

    public function addAction() {
        $form = new ProductForm($this->getEntityManager(), $this->identity());
        $product = new ProductEntity();
        $form->bind($product);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($product);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlproduct');
            }
        }
        return array(
            'form' => $form,
        );
    }

    public function editAction() {
        $id = $this->params()->fromRoute('id', 0);
        $em = $this->getEntityManager();
        $product = $em->find($this->getRepository(), $id);
        $form = new ProductForm($this->getEntityManager(), $this->identity());
        $form->bind($product);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em->persist($product);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlproduct');
            }
        }
        return array(
            'form' => $form,
            'product' => $product,
        );
    }

    public function deleteAction() {
        $em = $this->getEntityManager();
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('dtladmin/dtlproduct');
        }
        $product = $em->find($this->getRepository(), $id);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $product = $em->find($this->getRepository(), $id);
                $product->setProductActive(false);
                $em->persist($product);
                $em->flush();
            }
            return $this->redirect()->toRoute('dtladmin/dtlproduct');
        }
        return array(
            'id' => $id,
            'product' => $product,
        );
    }

    public function listAction() {
        $id = $this->params()->fromQuery('id');
        $em = $this->getEntityManager();
        $products = $em->getRepository('DtlProduct\Entity\Product')->findBy(array(
            'categoryId' => $id,
            'productActive' => '1'
        ));
        return array(
            'products' => $products
        );
    }

    /**
     * @return the $entityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * @param field_type $entityManager
     */
    public function setEntityManager(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @return the $repository
     */
    public function getRepository() {
        return $this->repository;
    }

    /**
     * @param field_type $repository
     */
    public function setRepository($repository) {
        $this->repository = $repository;
    }

}
