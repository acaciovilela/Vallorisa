<?php

namespace DtlPretender\Controller;

use DtlPretender\Entity\Pretender as PretenderEntity;
use DtlPretender\Form\Pretender as PretenderForm;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class PretenderController extends AbstractActionController {

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
            if (!empty($formSearch->pretender_cod_search)) {
                $query->andWhere("s.id = :cod");
                $query->setParameter('cod', $formSearch->pretender_cod_search);
            } elseif (!empty($formSearch->pretender_name_search)) {
                $query->andWhere("p.name LIKE :name");
                $query->setParameter('name', $formSearch->pretender_name_search . '%');
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
            'pretender' => $paginator
        );
    }

    public function addAction() {
        $personType = $this->params('type', base64_encode(0));
        $form = new PretenderForm($this->getEntityManager());
        $pretender = new PretenderEntity();
        $pretender->setUser($this->dtlUserMasterIdentity());
        $pretender->getPerson()->setType(base64_decode($personType));
        $form->bind($pretender);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($pretender);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Interessado cadastrado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlpretender');
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
            return $this->redirect()->toRoute('dtladmin/dtlpretender/add/' . $personType);
        }
        $form = new PretenderForm($this->getEntityManager());
        $form->bind($item);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($item);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Interessado atualizado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlpretender');
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
            return $this->redirect()->toRoute('dtladmin/dtlpretender');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
            }
            $this->flashMessenger()->addSuccessMessage('Interessado apagado com sucesso!');
            return $this->redirect()->toRoute('dtladmin/dtlpretender');
        }
        return array(
            'id' => $id,
            'pretender' => $em->find($this->getRepository(), $id),
        );
    }

    public function viewAction() {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $item = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlpretender');
        }
        return array(
            'id' => $id,
            'pretender' => $em->find($this->getRepository(), $id),
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
