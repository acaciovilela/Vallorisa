<?php

namespace DtlAccountingItem\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlAccountingItem\Form\AccountingItem as AccountingItemForm;
use DtlAccountingItem\Entity\AccountingItem as AccountingItemEntity;
use Doctrine\ORM\EntityManager;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Zend\Paginator\Paginator;

class AccountingItemController extends AbstractActionController {

    /**
     * @var AccountingItem\Entity\AccountingItemEntity
     */
    protected $repository;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function indexAction() {

        $adapter = new DoctrineAdapter(
                new DoctrinePaginator($this->getEntityManager()
                        ->getRepository($this->getRepository())
                        ->createQueryBuilder('ai')
                        ->where('ai.user = ' . $this->dtlUserMasterIdentity()->getId())
                        ->orderBy('ai.name', 'ASC')
        ));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);

        $page = $this->params()->fromRoute('page', 0);

        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return array(
            'accountingItem' => $paginator
        );
    }

    public function addAction() {
        $form = new AccountingItemForm($this->getEntityManager());
        $accountingItem = new AccountingItemEntity();
        $form->bind($accountingItem);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $accountingItem->setUser($this->dtlUserMasterIdentity());
                $em->persist($accountingItem);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlaccountingitem');
            }
        }
        return array(
            'form' => $form
        );
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $accountingItem = $em->find($this->getRepository(), $id);
        if (!$accountingItem) {
            return $this->redirect()->toRoute('dtladmin/dtlaccountingitem/add');
        }
        $form = new AccountingItemForm($this->getEntityManager());
        $form->bind($accountingItem);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($accountingItem);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlaccountingitem');
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
            return $this->redirect()->toRoute('dtladmin/dtlaccountingitem');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
            }
            return $this->redirect()->toRoute('dtladmin/dtlaccountingitem');
        }
        return array(
            'id' => $id,
            'accountingItem' => $em->find($this->getRepository(), $id),
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
