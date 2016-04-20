<?php

namespace DtlLocation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DtlLocation\Form\Country as CountryForm;
use DtlLocation\Entity\Country as CountryEntity;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class CountryController extends AbstractActionController {

    protected $entityManager = null;
    protected $repository = null;

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
            'countries' => $paginator,
        );
    }

    public function addAction() {
        $form = new CountryForm($this->getEntityManager());
        $country = new CountryEntity();
        $form->bind($country);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($country);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('País cadastrado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtllocation/country');
            }
        }
        return array(
            'form' => $form
        );
    }
    
    public function editAction() {
        $id = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $form = new CountryForm($this->getEntityManager());
        if ($id) {
            $country = $em->find($this->getRepository(), $id);
        } else {
            $this->flashMessenger()->addInfoMessage('Nenhum registro válido encontrado!');
            $this->redirect()->toRoute('dtladmin/dtllocation/country');
        }
        $form->bind($country);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($country);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('País atualizado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtllocation/country');
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
            return $this->redirect()->toRoute('dtladmin/dtllocation/country');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('País excluído com sucesso!');
            }
            return $this->redirect()->toRoute('dtladmin/dtllocation/country');
        }
        return array(
            'id' => $id,
            'country' => $em->find($this->getRepository(), $id),
        );
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    public function setRepository($repository) {
        $this->repository = $repository;
        return $this;
    }

}
