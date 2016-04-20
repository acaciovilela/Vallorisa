<?php

namespace DtlEmployee\Controller;

use DtlEmployee\Entity\Employee as EmployeeEntity;
use DtlEmployee\Form\Employee as EmployeeForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use Zend\Crypt\Password\Bcrypt;

class EmployeeController extends AbstractActionController {

    protected $repository;
    protected $entityManager;

    public function indexAction() {
        $query = $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->createQueryBuilder('e')
                ->join('e.person', 'p')
                ->andwhere('e.isActive = TRUE')
                ->andwhere('e.user = ' . $this->dtlUserMasterIdentity()->getId())
                ->orderBy('p.name', 'ASC');

        if ($this->request->isPost()) {
            $formSearch = $this->getRequest()->getPost();
            if (!empty($formSearch->employee_cod_search)) {
                $query->andWhere("e.id = :cod");
                $query->setParameter('cod', $formSearch->employee_cod_search);
            } elseif (!empty($formSearch->employee_name_search)) {
                $query->andWhere("p.name LIKE :name");
                $query->setParameter('name', $formSearch->employee_name_search . '%');
            } elseif (!empty($formSearch->employee_doc_search)) {
                $docNumber = trim($formSearch->employee_doc_search);
                if (strlen($docNumber) == 11) {
                    $query->join('p.individual', 'i')
                            ->andWhere('i.cpf = :individual')
                            ->setParameter('individual', $docNumber);
                } elseif (strlen($docNumber) == 14) {
                    $query->join('p.legal', 'l')
                            ->andWhere('l.cnpj = :legal')
                            ->setParameter('legal', $docNumber);
                }
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
            'employee' => $paginator
        );
    }

    public function addAction() {
        $fm = $this->serviceLocator->get('FormElementManager');
        $form = $fm->get('EmployeeForm');
        $employee = new EmployeeEntity();
        $form->bind($employee);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $supplier = $employee->getSupplier();
                $supplier->setPerson($employee->getPerson());
                $supplier->getUser($employee->getUser());
                $em->persist($supplier);
                $employee->setUser($this->dtlUserMasterIdentity());
                $employee->setSupplier($supplier);
                $em->persist($employee);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlemployee');
            }
        }
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function editAction() {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $employee = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$employee) {
            return $this->redirect()->toRoute('dtladmin/dtlemployee/add');
        }
        $fm = $this->serviceLocator->get('FormElementManager');
        $form = $fm->get('EmployeeForm');
        $form->bind($employee);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                if (!$employee->getSupplier()) {
                    $supplier = new \Supplier\Entity\Supplier();
                    $supplier->setPerson($employee->getPerson());
                    $supplier->setCompany($employee->getCompany());
                    $em->persist($supplier);
                    $employee->setSupplier($supplier);
                }
                $em->persist($employee);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlemployee');
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
            return $this->redirect()->toRoute('dtladmin/dtlemployee');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $employee = $em->find($this->getRepository(), $id);
                $employee->setIsActive(false);
                $em->persist($employee);
                $em->flush();
            }
            return $this->redirect()->toRoute('dtladmin/dtlemployee');
        }
        return array(
            'id' => $id,
            'employee' => $em->find($this->getRepository(), $id),
        );
    }

    public function viewAction() {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $item = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlemployee');
        }
        return array(
            'id' => $id,
            'employee' => $em->find($this->getRepository(), $id),
        );
    }

    public function launchsalaryAction() {
        $id = $this->params()->fromPost('employeeId');
        $em = $this->getEntityManager();
        if (isset($id)) {
            $employee = $em->find($this->getRepository(), $id);
            $payable = new \DtlFinancial\Entity\Payable();
            $payable->setUser($employee->getUser());
            $payable->setSupplier($employee->getSupplier());
            $payable->getAccount()->setDescription("REND. SALÁRIO DE {$employee->getName()}.");
            $salary = $employee->getSalary() + $employee->getBonus();
            $payable->getAccount()->setValue($salary);
            $collection = new \Doctrine\Common\Collections\ArrayCollection();
            $collection->add($payable);
            $employee->addPayments($collection);
            $em->persist($employee);
            $em->flush();
        }

        return $this->response->setContent(\Zend\Json\Json::encode(array('result' => true)));
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
