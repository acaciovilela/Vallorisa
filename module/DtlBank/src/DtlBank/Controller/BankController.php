<?php

namespace DtlBank\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlBank\Form\Bank as BankForm;
use DtlBank\Entity\Bank as BankEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class BankController extends AbstractActionController {

    /**
     * @var DtlBank\Entity\BankEntity
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
                ->createQueryBuilder('b')
                ->orderBy('b.name');

        return array(
            'bank' => $query->getQuery()->getResult(),
        );
    }

    public function addAction() {
        $form = new BankForm($this->getEntityManager());
        $bank = new BankEntity();
        $form->bind($bank);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($bank);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Banco cadastrado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlbank');
            }
        }
        return array(
            'form' => $form
        );
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $bank = $em->find($this->getRepository(), $id);
        if (!$bank) {
            return $this->redirect()->toRoute('dtladmin/dtlbank/add');
        }
        $form = new BankForm($this->getEntityManager());
        $form->bind($bank);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($bank);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Banco atualizado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlbank');
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
        $em = $this->getEntityManager();
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('dtladmin/dtlbank');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Banco apagado com sucesso!');
            }
            return $this->redirect()->toRoute('dtladmin/dtlbank');
        }
        return array(
            'bank_id' => $id,
            'bank' => $em->find($this->getRepository(), $id),
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
