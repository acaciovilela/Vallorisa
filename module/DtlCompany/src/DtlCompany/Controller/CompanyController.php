<?php

namespace DtlCompany\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;
use DtlCompany\Entity\Company as CompanyEntity;
use DtlCompany\Form\Company as CompanyForm;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Zend\Paginator\Paginator;
use Zend\Crypt\Password\Bcrypt;

class CompanyController extends AbstractActionController {

    /**
     * @var DtlCompany\Entity\CompanyEntity
     */
    protected $repository;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function indexAction() {

        $company = $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->createQueryBuilder('c')
                ->where('c.isActive = TRUE')
                ->andWhere('c.user = ' . $this->dtlUserMasterIdentity()->getId())
                ->orderBy('c.name', 'ASC')
                ->getQuery()
                ->getResult();

        return array(
            'company' => $company
        );
    }

    public function addAction() {
        $form = new CompanyForm($this->getEntityManager());
        $company = new CompanyEntity();
        $form->bind($company);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($company);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlcompany');
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
            return $this->redirect()->toRoute('dtladmin/dtlcompany/add');
        }
        $form = new CompanyForm($em);
        $form->bind($item);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($item);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlcompany');
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
            return $this->redirect()->toRoute('dtladmin/dtlcompany');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $company = $em->find($this->getRepository(), $id);
                $company->setCompanyIsActive(false);
                $em->persist($company);
                $em->flush();
            }
            return $this->redirect()->toRoute('dtladmin/dtlcompany');
        }
        return array(
            'company_id' => $id,
            'company' => $em->find($this->getRepository(), $id),
        );
    }

    public function viewAction() {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $item = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlcompany');
        }
        return array(
            'id' => $id,
            'company' => $em->find($this->getRepository(), $id),
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
