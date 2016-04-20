<?php

namespace DtlProduct\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlProduct\Form\Category as CategoryForm;
use DtlProduct\Entity\Category as CategoryEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class CategoryController extends AbstractActionController {

    /**
     * @var Category\Entity\CategoryEntity
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
                ->createQueryBuilder('c')
                ->where('c.user = ' . $this->dtlUserMasterIdentity()->getId())
                ->orderBy('c.name', 'ASC');

        if ($this->request->isPost()) {
            $formSearch = $this->getRequest()->getPost();
            if (!empty($formSearch->category_cod_search)) {
                $query->andWhere("c.id = :cod");
                $query->setParameter('cod', $formSearch->category_cod_search);
            } elseif (!empty($formSearch->category_name_search)) {
                $query->andWhere("c.name LIKE :name");
                $query->setParameter('name', '%' . $formSearch->category_name_search . '%');
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
            'category' => $paginator
        );
    }

    public function addAction() {
        $em = $this->getEntityManager();
        $form = new CategoryForm($em);
        $category = new CategoryEntity();
        $form->bind($category);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $category->setUser($this->identity());
                $em->persist($category);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlcategory');
            }
        }
        return array(
            'form' => $form
        );
    }

    public function editAction() {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $item = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlcategory/add');
        }
        $form = new CategoryForm($em);
        $form->bind($item);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($item);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlcategory');
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $em = $this->getEntityManager();
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('dtladmin/dtlcategory');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
            }
            return $this->redirect()->toRoute('dtladmin/dtlcategory');
        }
        return array(
            'id' => $id,
            'category' => $em->find($this->getRepository(), $id),
        );
    }

    public function viewAction() {
        
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
