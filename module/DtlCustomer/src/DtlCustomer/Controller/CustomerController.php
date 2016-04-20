<?php

namespace DtlCustomer\Controller;

use DtlCustomer\Entity\Customer as CustomerEntity;
use DtlCustomer\Form\Customer as CustomerForm;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class CustomerController extends AbstractActionController {

    /**
     *
     * @var string
     */
    protected $repository;
    
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function indexAction() {
        
        $query = $this->getEntityManager()
                        ->getRepository($this->getRepository())
                        ->createQueryBuilder('c')
                        ->join('c.person', 'p')
                        ->where('c.user = ' . $this->dtlUserMasterIdentity()->getId())
                        ->andwhere('c.isActive = TRUE')
                        ->orderBy('p.name', 'ASC');
        
        if ($this->request->isPost()) {
            $formSearch = $this->getRequest()->getPost();
            if (!empty($formSearch->customer_cod_search)) {
                $query->andWhere("c.id = :cod");
                $query->setParameter('cod', $formSearch->customer_cod_search);
            } elseif (!empty($formSearch->customer_name_search)) {
                $query->andWhere("p.name LIKE :name");
                $query->setParameter('name', $formSearch->customer_name_search . '%');
            } elseif (!empty($formSearch->customer_doc_search)) {
                $docNumber = trim($formSearch->customer_doc_search);
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
            'customer' => $paginator
        );
    }

    public function addAction() {
        $personType = $this->params('type', base64_encode(0));
        $form = new CustomerForm($this->getEntityManager());
        $customer = new CustomerEntity();
        $customer->getPerson()->setType(base64_decode($personType));
        $form->bind($customer);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($customer);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlcustomer');
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
            return $this->redirect()->toRoute('dtladmin/dtlcustomer/add/' . $personType);
        }
        $form = new CustomerForm($this->getEntityManager());
        $form->bind($item);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($item);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlcustomer');
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
            return $this->redirect()->toRoute('dtladmin/dtlcustomer');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $customer = $em->find($this->getRepository(), $id);
                $customer->setIsActive(false);
                $em->persist($customer);
                $em->flush();
            }
            return $this->redirect()->toRoute('dtladmin/dtlcustomer');
        }
        return array(
            'id' => $id,
            'customer' => $em->find($this->getRepository(), $id),
        );
    }

    public function viewAction() {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $item = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlcustomer');
        }
        return array(
            'id' => $id,
            'customer' => $em->find($this->getRepository(), $id),
        );
    }
    
    public function exportCsvAction() {
        $header = array(
            'ID',
            'CLIENTE',
            'CPF/CNPJ',
            'ENDEREÇO',
            'Nº',
            'BAIRRO',
            'CIDADE',
            'ESTADO',
            'EMAIL',
            'TELEFONE',
            'CELULAR',
        );
        
        $em = $this->getEntityManager();
        $query = $em->getRepository($this->getRepository())
                ->createQueryBuilder('c')
                ->select('c.id, p.name, p.type, l.cnpj, '
                        . 'i.cpf, a.name, a.number, '
                        . 'a.quarter, a.city, a.state, '
                        . 'ct.email, ct.phone, ct.cell')
                ->join('c.person', 'p')
                ->join('p.address', 'a')
                ->join('p.contact', 'ct')
                ->leftJoin('p.legal', 'l')
                ->leftJoin('p.individual', 'i')
                ->where('c.isActive = true')
                ->orderBy('p.name', 'ASC')
                ->getQuery();
        
        $customers = $query->getResult();
        
        $data = array();
        
        foreach ($customers as $customer) {
            if ($customer['type']) {
                $person_doc = $customer['cnpj'];
            } else {
                $person_doc = $customer['cpf'];
            }
            $data[] = array(
                $customer['id'],
                $customer['personName'],
                $person_doc,
                $customer['addressName'],
                $customer['addressNumber'],
                $customer['addressQuarter'],
                $customer['addressCity'],
                $customer['addressState'],
                $customer['contactEmail'],
                $customer['contactPhone'],
                $customer['contactCell'],
            );
        }
        
        return $this->csvExport('clientes', $header, $data, null, ';');
    }

    public function getRepository() {
        return $this->repository;
    }

    public function setRepository($repository) {
        $this->repository = $repository;
    }

    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }
}
