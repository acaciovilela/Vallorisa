<?php

namespace DtlLocation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DtlLocation\Form\State as StateForm;
use DtlLocation\Entity\State as StateEntity;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class StateController extends AbstractActionController {

    protected $entityManager;
    
    protected $repository;

    public function indexAction() {
        $adapter = new DoctrineAdapter(
                new DoctrinePaginator($this->getEntityManager()
                        ->getRepository($this->getRepository())
                        ->createQueryBuilder('c')
                        ->orderBy('c.name')
        ));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);

        $page = $this->params()->fromRoute('page');

        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return array(
            'states' => $paginator,
        );
    }

    public function addAction() {
        $form = new StateForm($this->getEntityManager());
        $state = new StateEntity();
        $form->bind($state);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($state);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Estado cadastrado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtllocation/state');
            }
        }
        return array(
            'form' => $form
        );
    }
    
    public function editAction() {
        $id = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $form = new StateForm($this->getEntityManager());
        if ($id) {
            $state = $em->find($this->getRepository(), $id);
        } else {
            $this->flashMessenger()->addInfoMessage('Nenhum registro válido encontrado!');
            $this->redirect()->toRoute('dtladmin/dtllocation/state');
        }
        $form->bind($state);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($state);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Estado atualizado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtllocation/state');
            }
        }
        return array(
            'form' => $form,
            'id' => $id
        );
    }
    
    public function deleteAction() {
        $em = $this->getEntityManager();
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('dtladmin/dtllocation/state');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Estado excluído com sucesso!');
            }
            return $this->redirect()->toRoute('dtladmin/dtllocation/state');
        }
        return array(
            'id' => $id,
            'state' => $em->find($this->getRepository(), $id),
        );
    }
    
    function getEntityManager() {
        return $this->entityManager;
    }

    function getRepository() {
        return $this->repository;
    }

    function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    function setRepository($repository) {
        $this->repository = $repository;
        return $this;
    }
}
