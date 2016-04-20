<?php

namespace DtlEmployeeStatus\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlEmployeeStatus\Form\EmployeeStatus as EmployeeStatusForm;
use DtlEmployeeStatus\Entity\EmployeeStatus as EmployeeStatusEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class EmployeeStatusController extends AbstractActionController {

    /**
     * @var DtlEmployeeStatus\Entity\EmployeeStatusEntity
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
                        ->createQueryBuilder('es')
                        ->orderBy('es.name')
        ));
        
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        
        $page = $this->params()->fromRoute('page');
        
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }
        
        return array(
            'employeeStatus' => $paginator
        );
    }

    public function addAction() {
        $form = new EmployeeStatusForm($this->getEntityManager());
        $employeeStatus = new EmployeeStatusEntity();
        $form->bind($employeeStatus);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($employeeStatus);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlemployeestatus');
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
            return $this->redirect()->toRoute('dtladmin/dtlemployeestatus/add');
        }
        $form = new EmployeeStatusForm($this->getEntityManager());
        $form->bind($item);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($item);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlemployeestatus');
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
            return $this->redirect()->toRoute('dtladmin/dtlemployeestatus');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
            }
            return $this->redirect()->toRoute('dtladmin/dtlemployeestatus');
        }
        return array(
            'id' => $id,
            'employeeStatus' => $em->find($this->getRepository(), $id),
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
