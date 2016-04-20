<?php

namespace DtlFinancial\Controller;

use DtlFinancial\Entity\Expense as ExpenseEntity;
use DtlFinancial\Form\Expense as ExpenseForm;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class ExpenseController extends AbstractActionController {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;
    
    /**
     * @var DtlFinancial\Service\Expense
     */
    protected $service;

    public function indexAction() {
        $adapter = new DoctrineAdapter(
            new DoctrinePaginator($this->getService()->getPaginationResult(
                    $this->dtlUserMasterIdentity()->getId()))
        );
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $page = $this->params()->fromRoute('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }
        $expenseTotal = $this->getService()->getExpenseTotal($this->dtlUserMasterIdentity()->getId());
        return array(
            'expense' => $paginator,
            'total' => $expenseTotal,
        );
    }

    public function addAction() {
        $form = new ExpenseForm($this->getEntityManager(), $this->dtlUserMasterIdentity()->getId());
        $expense = new ExpenseEntity();
        $form->bind($expense);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $expense->setUser($this->dtlUserMasterIdentity());
                $em->persist($expense);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Despesa cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlfinancial/cash');
            } else {
                $this->flashMessenger()->addErrorMessage('Ocorreu um erro ao tentar gravar os dados!');
            }
        }
        return array(
            'form' => $form,
        );
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $expense = $this->getService()->findOneBy(array('id' => $id));
        if (!$expense) {
            return $this->redirect()->toRoute('dtladmin/dtlfinancial/expense/add/');
        }
        $form = new ExpenseForm($this->getEntityManager(), $this->dtlUserMasterIdentity()->getId());
        $form->bind($expense);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($expense);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Despesa atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlfinancial/expense');
            } else {
                $this->flashMessenger()->addErrorMessage('Ocorreu um erro ao tentar gravar os dados!');
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->layout('layout/blank');
        }
        $em = $this->getEntityManager();
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('dtladmin/dtlfinancial/expense');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($this->getService()->find($id));
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Despesa apagada com sucesso!');
            }
            return $this->redirect()->toRoute('dtladmin/dtlfinancial/expense');
        }
        return array(
            'id' => $id,
            'expense' => $this->getService()->find($id),
        );
    }

    public function viewAction() {
        $id = (int) $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $item = $this->getService()->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlfinancial/expense');
        }
        return array(
            'id' => $id,
            'expense' => $em->find($this->getRepository(), $id),
        );
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function getService() {
        return $this->service;
    }

    public function setService($service) {
        $this->service = $service;
        return $this;
    }
}
