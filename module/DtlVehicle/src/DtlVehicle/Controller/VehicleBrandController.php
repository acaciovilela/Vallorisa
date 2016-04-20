<?php

namespace DtlVehicle\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlVehicle\Form\VehicleBrand as VehicleBrandForm;
use DtlVehicle\Entity\VehicleBrand as VehicleBrandEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class VehicleBrandController extends AbstractActionController {

    /**
     * @var VehicleBrand\Entity\VehicleBrandEntity
     */
    protected $repository;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function indexAction() {

        $adapter = new DoctrineAdapter(
                new DoctrinePaginator($this->getEntityManager()
                        ->getRepository($this->getRepository())
                        ->createQueryBuilder('vb')
                        ->orderBy('vb.name')
        ));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $page = $this->params()->fromRoute('page');
        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }
        return array(
            'vehicleBrand' => $paginator
        );
    }

    public function addAction() {
        $form = new VehicleBrandForm($this->getEntityManager());
        $vehicleBrand = new VehicleBrandEntity();
        $form->bind($vehicleBrand);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($vehicleBrand);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Marca cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlvehicle/vehicle-brand');
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
            $this->flashMessenger()->addErrorMessage('Marca inválida!');
            return $this->redirect()->toRoute('dtladmin/dtlvehicle/vehicle-brand');
        }
        $form = new VehicleBrandForm($this->getEntityManager());
        $form->bind($item);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($item);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Marca atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlvehicle/vehicle-brand');
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
            $this->flashMessenger()->addSuccessMessage('A marca solicitada não existe!');
            return $this->redirect()->toRoute('dtladmin/dtlvehicle/vehicle-brand');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
            }
            $this->flashMessenger()->addSuccessMessage('Marca apagada com sucesso!');
            return $this->redirect()->toRoute('dtladmin/dtlvehicle/vehicle-brand');
        }
        return array(
            'id' => $id,
            'vehicleBrand' => $em->find($this->getRepository(), $id),
        );
    }
    
    public function getRepository() {
        if (!$this->repository) {
            $this->repository = '\DtlVehicle\Entity\VehicleBrand';
        }
        return $this->repository;
    }

    public function setRepository(\DtlVehicle\Entity\VehicleBrand $repository) {
        $this->repository = $repository;
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return \Brand\Controller\BrandController
     */
    public function setEntityManager(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

}
