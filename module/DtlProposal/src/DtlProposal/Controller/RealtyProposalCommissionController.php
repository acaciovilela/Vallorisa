<?php

namespace DtlProposal\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlProposal\Form\RealtyProposalCommission as RealtyProposalCommissionForm;
use DtlProposal\Entity\RealtyProposalCommission as RealtyProposalCommissionEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class RealtyProposalCommissionController extends AbstractActionController {

    /**
     * @var DtlProposal\Entity\RealtyProposalCommission
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
                        ->createQueryBuilder('rpc')
                        ->where('rpc.isActive = true')
                        ->orderBy('rpc.id', 'ASC')
        ));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);

        $page = $this->params()->fromRoute('page');

        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return array(
            'realtyProposalCommission' => $paginator,
        );
    }

    public function addAction() {
        $form = new RealtyProposalCommissionForm($this->getEntityManager());
        $realtyProposalCommission = new RealtyProposalCommissionEntity();
        $form->bind($realtyProposalCommission);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($realtyProposalCommission);
                $em->flush();
                $this->flashMessenger()->addMessage('Comissão cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal-commission');
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
            return $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal-commission/add');
        }
        $form = new RealtyProposalCommissionForm($this->getEntityManager());
        $form->bind($item);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($item);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal-commission');
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
            return $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal-commission');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $commission = $em->find($this->getRepository(), $id);
                $commission->setIsActive(false);
                $em->persist($commission);
                $em->flush();
            }
            return $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal-commission');
        }
        return array(
            'id' => $id,
            'realtyProposalCommission' => $em->find($this->getRepository(), $id),
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
