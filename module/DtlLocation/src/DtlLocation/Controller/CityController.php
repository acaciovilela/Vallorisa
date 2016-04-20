<?php

namespace DtlLocation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DtlLocation\Form\City as CityForm;
use DtlLocation\Entity\City as CityEntity;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use Zend\Json\Json;

class CityController extends AbstractActionController {

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
            'cities' => $paginator,
        );
    }

    public function addAction() {
        $form = new CityForm($this->getEntityManager());
        $city = new CityEntity();
        $form->bind($city);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($city);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Cidade cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtllocation/city');
            }
        }
        return array(
            'form' => $form
        );
    }
    
    public function editAction() {
        $id = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $form = new CityForm($this->getEntityManager());
        if ($id) {
            $city = $em->find($this->getRepository(), $id);
        } else {
            $this->flashMessenger()->addInfoMessage('Nenhum registro válido encontrado!');
            $this->redirect()->toRoute('dtladmin/dtllocation/city');
        }
        $form->bind($city);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($city);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Cidade atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtllocation/city');
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
            return $this->redirect()->toRoute('dtladmin/dtllocation/city');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Cidade excluída com sucesso!');
            }
            return $this->redirect()->toRoute('dtladmin/dtllocation/city');
        }
        return array(
            'id' => $id,
            'city' => $em->find($this->getRepository(), $id),
        );
    }
    
    public function fillAction() {
        $id = $this->params()->fromQuery('itemId');
        $em = $this->getEntityManager();
        $state = $em->find('DtlLocation\Entity\State', $id);
        $cities = $em->getRepository('DtlLocation\Entity\City')
                ->findBy(array('state' => $state), array('name' => 'ASC'));
        $options = '';
        foreach ($cities as $city) {
            $options .= '<option value="'. $city->getId() .'">' . $city->getName() . '</option>';
        }
        return $this->getResponse()->setContent(Json::encode(array('options' => $options)));
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
