<?php

namespace DtlFinancial\Controller;

use DtlFinancial\Entity\Revenue as RevenueEntity;
use DtlFinancial\Form\Revenue as RevenueForm;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class RevenueController extends AbstractActionController {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var DtlFinancial\Service\Revenue
     */
    protected $service;

    public function indexAction() {
        $adapter = new DoctrineAdapter(
                new DoctrinePaginator($this->getService()
                        ->getPaginationResult($this->dtlUserMasterIdentity()->getId()))
        );
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $page = $this->params()->fromRoute('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }
        $revenueTotal = $this->getService()->getRevenueTotal(
                $this->dtlUserMasterIdentity()->getId()
        );
        return array(
            'revenue' => $paginator,
            'total' => $revenueTotal,
        );
    }

    public function addAction() {
        $form = new RevenueForm($this->getEntityManager(), $this->dtlUserMasterIdentity()->getId());
        $revenue = new RevenueEntity();
        $form->bind($revenue);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $revenue->setUser($this->dtlUserMasterIdentity());
                $em->persist($revenue);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Receita cadastrada com sucesso!');
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
        $revenue = $this->getService()->findOneBy(array('id' => $id));
        if (!$revenue) {
            return $this->redirect()->toRoute('dtladmin/dtlfinancial/revenue/add/');
        }
        $form = new RevenueForm($this->getEntityManager(), $this->dtlUserMasterIdentity()->getId());
        $form->bind($revenue);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($revenue);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Receita atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlfinancial/revenue');
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
            return $this->redirect()->toRoute('dtladmin/dtlfinancial/revenue');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($this->getService()->find($id));
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Receita apagada com sucesso!');
            }
            return $this->redirect()->toRoute('dtladmin/dtlfinancial/revenue');
        }
        return array(
            'id' => $id,
            'revenue' => $this->getService()->find($id),
        );
    }

    public function viewAction() {
        $id = (int) $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $item = $this->getService()->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlfinancial/revenue');
        }
        return array(
            'id' => $id,
            'revenue' => $em->find($this->getRepository(), $id),
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
