<?php

namespace DtlPaymentType\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use DtlPaymentType\Form\PaymentType as PaymentTypeForm;
use DtlPaymentType\Entity\PaymentType as PaymentTypeEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;

class PaymentTypeController extends AbstractActionController {

    /**
     * @var PaymentType\Entity\PaymentTypeEntity
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
                        ->createQueryBuilder('pt')
                        ->where('pt.user = ' . $this->dtlUserMasterIdentity()->getId())
                        ->orderBy('pt.name', 'ASC')
        ));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);

        $page = $this->params()->fromRoute('page');

        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return array(
            'paymentType' => $paginator
        );
    }

    public function addAction() {
        $form = new PaymentTypeForm($this->getEntityManager());
        $paymentType = new PaymentTypeEntity();
        $form->bind($paymentType);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $paymentType->setUser($this->dtlUserMasterIdentity());
                $em->persist($paymentType);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Tipo de pagamento cadastrado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlpaymenttype');
            } else {
                $this->flashMessenger()->addErrorMessage('Ocorreu um erro ao tentar gravar os dados');
            }
        }
        return array(
            'form' => $form
        );
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $paymentType = $em->find($this->getRepository(), $id);
        if (!$paymentType) {
            return $this->redirect()->toRoute('dtladmin/dtlpaymenttype/add');
        }
        $form = new PaymentTypeForm($this->getEntityManager());
        $form->bind($paymentType);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($paymentType);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Tipo de pagamento atualizado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlpaymenttype');
            } else {
                $this->flashMessenger()->addErrorMessage('Ocorreu um erro ao tentar gravar os dados!');
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
            return $this->redirect()->toRoute('dtladmin/dtlpaymenttype');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Tipo de pagamento apagado com sucesso!');
            }
            return $this->redirect()->toRoute('dtladmin/dtlpaymenttype');
        }
        return array(
            'id' => $id,
            'paymentType' => $em->find($this->getRepository(), $id),
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
