<?php

namespace DtlRealtor\Controller;

use DtlRealtor\Entity\Realtor as RealtorEntity;
use DtlRealtor\Form\Realtor as RealtorForm;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use Zend\Json\Json;

class RealtorController extends AbstractActionController {

    protected $repository;
    protected $entityManager;

    public function indexAction() {

        $adapter = new DoctrineAdapter(
                new DoctrinePaginator($this->getEntityManager()
                        ->getRepository($this->getRepository())
                        ->createQueryBuilder('s')
                        ->join('s.person', 'p')
                        ->where('s.user = ' . $this->dtlUserMasterIdentity()->getId())
                        ->andWhere('s.isActive = TRUE')
                        ->orderBy('p.name', 'ASC')
        ));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);

        $page = $this->params()->fromRoute('page');

        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return array(
            'realtor' => $paginator
        );
    }

    public function addAction() {
        $personType = $this->params('type', base64_encode(0));
        $form = new RealtorForm($this->getEntityManager());
        $realtor = new RealtorEntity();
        $realtor->getPerson()->setType(base64_decode($personType));
        $form->bind($realtor);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $realtor->setUser($this->dtlUserMasterIdentity());
                $supplier = $realtor->getSupplier();
                if (!$supplier) {
                    $supplier = new \DtlSupplier\Entity\Supplier();
                    $supplier->setPerson($realtor->getPerson());
                    $supplier->setUser($realtor->getUser());
                    $realtor->setSupplier($supplier);
                }
                $em->persist($realtor);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlrealtor');
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
        $realtor = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$realtor) {
            return $this->redirect()->toRoute('dtladmin/dtlrealtor/add/' . $personType);
        }
        $form = new RealtorForm($this->getEntityManager());
        $form->bind($realtor);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $supplier = $realtor->getSupplier();
                if (!$supplier) {
                    $supplier = new \DtlSupplier\Entity\Supplier();
                    $supplier->setPerson($realtor->getPerson());
                    $supplier->setUser($realtor->getUser());
                    $realtor->setSupplier($supplier);
                }
                $em->persist($realtor);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlrealtor');
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
            return $this->redirect()->toRoute('dtladmin/dtlrealtor');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $realtor = $em->find($this->getRepository(), $id);
                $realtor->setIsActive(false);
                $em->persist($realtor);
                $em->flush();
            }
            return $this->redirect()->toRoute('dtladmin/dtlrealtor');
        }
        return array(
            'id' => $id,
            'realtor' => $em->find($this->getRepository(), $id),
        );
    }

    public function viewAction() {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $item = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlrealtor');
        }
        return array(
            'id' => $id,
            'realtor' => $em->find($this->getRepository(), $id),
        );
    }

    public function fillAction() {
        $realtorId = (int) $this->params()->fromQuery('itemId');
        $em = $this->getEntityManager();
        $realtor = $em->find($this->getRepository(), $realtorId);
        $sellers = $realtor->getRealtorSeller();
        $options = '';
        foreach ($sellers as $seller) {
            $options .= '<option value="' . $seller->getId() . '">' . $seller->getPerson()->getName() . '</option>';
        }
        return $this->getResponse()->setContent(Json::encode(array('options' => $options)));
    }

    public function fillproductAction() {
        $realtorId = (int) $this->params()->fromQuery('itemId');
        $em = $this->getEntityManager();
        $realtor = $em->find($this->getRepository(), $realtorId);
        $product = $realtor->getRealtorProduct();
        $options = '';
        foreach ($product as $seller) {
            $options .= '<option value="' . $seller->getId() . '">' . $seller->getName() . '</option>';
        }
        return $this->getResponse()->setContent(Json::encode(array('options' => $options)));
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
