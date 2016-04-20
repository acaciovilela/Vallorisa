<?php

namespace DtlDocumentType\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlDocumentType\Form\DocumentType as DocumentTypeForm;
use DtlDocumentType\Entity\DocumentType as DocumentTypeEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class DocumentTypeController extends AbstractActionController {

    /**
     * @var DocumentType\Entity\DocumentTypeEntity
     */
    protected $repository;

    /**
     * @
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function indexAction() {
        $adapter = new DoctrineAdapter(
                new DoctrinePaginator($this->getEntityManager()
                        ->getRepository($this->getRepository())
                        ->createQueryBuilder('d')
                        ->where('d.user = ' . $this->dtlUserMasterIdentity()->getId())
                        ->orderBy('d.name', 'ASC')
        ));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);

        $page = $this->params()->fromRoute('page');

        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return array(
            'documentType' => $paginator
        );
    }

    public function addAction() {
        $form = new DocumentTypeForm($this->getEntityManager());
        $documentType = new DocumentTypeEntity();
        $form->bind($documentType);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $documentType->setUser($this->dtlUserMasterIdentity());
                $em->persist($documentType);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Tipo de documento cadastrado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtldocumenttype');
            } else {
                $this->flashMessenger()->addErrorMessage('Ocorreu um erro ao tentar gravar os dados!');
            }
        }
        return array(
            'form' => $form
        );
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $documentType = $em->find($this->getRepository(), $id);
        if (!$documentType) {
            return $this->redirect()->toRoute('dtladmin/dtldocumenttype/add');
        }
        $form = new DocumentTypeForm($this->getEntityManager());
        $form->bind($documentType);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($documentType);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Tipo de documento atualizado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtldocumenttype');
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
            return $this->redirect()->toRoute('dtladmin/dtldocumenttype');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Tipo de documento apagado com sucesso!');
            }
            return $this->redirect()->toRoute('dtladmin/dtldocumenttype');
        }
        return array(
            'id' => $id,
            'documentType' => $em->find($this->getRepository(), $id),
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
