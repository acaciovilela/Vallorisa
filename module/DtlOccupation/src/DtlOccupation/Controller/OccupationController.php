<?php

namespace DtlOccupation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlOccupation\Form\Occupation as OccupationForm;
use DtlOccupation\Entity\Occupation as OccupationEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class OccupationController extends AbstractActionController {

    /**
     * @var DtlOccupation\Entity\OccupationEntity
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
                        ->createQueryBuilder('o')
                        ->orderBy('o.name')
        ));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);

        $page = $this->params()->fromRoute('page');

        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return array(
            'occupation' => $paginator,
        );
    }

    public function addAction() {
        $em = $this->getEntityManager();
        $form = new OccupationForm($em);
        $occupation = new OccupationEntity();
        $form->bind($occupation);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em->persist($occupation);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Profissão cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtloccupation');
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
            return $this->redirect()->toRoute('dtladmin/dtloccupation/add');
        }
        $form = new OccupationForm($em);
        $form->bind($item);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($item);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Profissão atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtloccupation');
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
            $this->flashMessenger()->addErrorMessage('Esta não é uma profissão válida!');
            return $this->redirect()->toRoute('dtladmin/dtloccupation');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
            }
            $this->flashMessenger()->addSuccessMessage('Profissão apagada com sucesso!');
            return $this->redirect()->toRoute('dtladmin/dtloccupation');
        }
        return array(
            'occupation_id' => $id,
            'occupation' => $em->find($this->getRepository(), $id),
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
