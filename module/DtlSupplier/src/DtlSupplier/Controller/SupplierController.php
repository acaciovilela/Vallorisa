<?php

namespace DtlSupplier\Controller;

use DtlSupplier\Entity\Supplier as SupplierEntity;
use DtlSupplier\Form\Supplier as SupplierForm;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class SupplierController extends AbstractActionController {

    protected $repository;
    protected $entityManager;

    public function indexAction() {

        $query = $this->getEntityManager()
                        ->getRepository($this->getRepository())
                        ->createQueryBuilder('s')
                        ->join('s.person', 'p')
                        ->where('s.user = ' . $this->dtlUserMasterIdentity()->getId())
                        ->andwhere('s.isActive = TRUE')
                        ->orderBy('p.name', 'ASC');
        
        if ($this->request->isPost()) {
            $formSearch = $this->getRequest()->getPost();
            if (!empty($formSearch->supplier_cod_search)) {
                $query->andWhere("s.id = :cod");
                $query->setParameter('cod', $formSearch->supplier_cod_search);
            } elseif (!empty($formSearch->supplier_name_search)) {
                $query->andWhere("p.name LIKE :name");
                $query->setParameter('name', $formSearch->supplier_name_search . '%');
            } elseif (!empty($formSearch->supplier_doc_search)) {
                $docNumber = trim($formSearch->supplier_doc_search);
                if (strlen($docNumber) == 11) {
                    $query->join('p.individual', 'i')
                            ->andWhere('i.cpf = :individual')
                            ->setParameter('individual', $docNumber);
                } elseif (strlen($docNumber) == 14) {
                    $query->join('p.legal', 'l')
                            ->andWhere('l.cnpj = :legal')
                            ->setParameter('legal', $docNumber);
                }
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
            'supplier' => $paginator
        );
    }

    public function addAction() {
        $personType = $this->params('type', base64_encode(0));
        $form = new SupplierForm($this->getEntityManager());
        $supplier = new SupplierEntity();
        $supplier->getPerson()->setType(base64_decode($personType));
        $form->bind($supplier);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($supplier);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Fornecedor cadastrado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlsupplier');
            }
        }
        return array(
            'form' => $form,
            'personType' => $personType
        );
    }

    public function editAction() {
        $personType = $this->params('type', base64_encode(0));
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $item = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlsupplier/add/' . $personType);
        }
        $form = new SupplierForm($this->getEntityManager());
        $form->bind($item);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($item);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Fornecedor atualizado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlsupplier');
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
            'personType' => $personType
        );
    }

    public function deleteAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->layout('layout/blank');
        }
        $em = $this->getEntityManager();
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('dtladmin/dtlsupplier');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $supplier = $em->find($this->getRepository(), $id);
                $supplier->setIsActive(FALSE);
                $em->flush();
            }
            $this->flashMessenger()->addSuccessMessage('Fornecedor apagado com sucesso!');
            return $this->redirect()->toRoute('dtladmin/dtlsupplier');
        }
        return array(
            'id' => $id,
            'supplier' => $em->find($this->getRepository(), $id),
        );
    }

    public function viewAction() {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $item = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlsupplier');
        }
        return array(
            'id' => $id,
            'supplier' => $em->find($this->getRepository(), $id),
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
