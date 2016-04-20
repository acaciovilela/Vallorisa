<?php

namespace DtlFinancial\Controller;

use DtlFinancial\Entity\Payable as PayableEntity;
use DtlFinancial\Form\Payable as PayableForm;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use DtlFinancial\Form\Discharge;

class PayableController extends AbstractActionController {

    protected $repository;

    /**
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    public function indexAction() {
        $adapter = $this->getEntityManager()
        ->getRepository($this->getRepository())
        ->createQueryBuilder('r')
        ->join('r.account', 'a')
        ->where('r.user = ' . $this->dtlUserMasterIdentity()->getId())
        ->andWhere('a.done = 0')
        ->orderBy('a.expirationDate', 'ASC');

        $payableTotal = $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->getPayableTotal();

//        $paginator = new Paginator($adapter);
//        $paginator->setDefaultItemCountPerPage(10);
//
//        $page = $this->params()->fromRoute('page');
//
//        if ($page) {
//            $paginator->setCurrentPageNumber($page);
//        }

        $form = new Discharge($this->getEntityManager());
        $form->setAttributes(array('action' => '/admin/financial/payable/1/discharge'));

        return array(
            'payable' => $adapter->getQuery()->getResult(),
            'total' => $payableTotal,
            'form' => $form,
        );
    }

    public function addAction() {
        $form = new PayableForm($this->getEntityManager(), $this->dtlUserMasterIdentity()->getId());
        $payable = new PayableEntity();
        $form->bind($payable);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $expiration = $form->getData()->getAccount()->getExpirationDate();
                $parcels = $form->getData()->getAccount()->getParcels();
                $isRecurrent = (bool) $form->getData()->getAccount()->getIsRecurrent();
                $em = $this->getEntityManager();
                $payable->getAccount()->setCurrentParcel(1 . "/" . (int) $parcels);
                $em->persist($payable);
                $em->flush();
                if (($parcels >= 1) && ($isRecurrent == true)) {
                    $recurrenceInterval = $form->getData()->getAccount()->getRecurrenceInterval();
                    for ($i = 1; $i < $parcels; $i++) {
                        $payable = new PayableEntity();
                        $payable->setUser($this->dtlUserMasterIdentity());
                        $form->bind($payable);
                        $form->setData($post);
                        if ($form->isValid()) {
                            $date = new \DateTime($expiration);
                            $timestamp = $date->getTimestamp();
                            $dateArray = array(
                                'hour' => date('h', $timestamp),
                                'minutes' => date('i', $timestamp),
                                'seconds' => date('s', $timestamp),
                                'month' => date('m', $timestamp),
                                'day' => date('d', $timestamp),
                                'year' => date('Y', $timestamp));
                            $expiration = date('Y-m-d', mktime(
                                            $dateArray['hour'], $dateArray['minutes'], $dateArray['seconds'], $dateArray['month'], $dateArray['day'] + $recurrenceInterval, $dateArray['year']
                            ));
                            $payable->getAccount()->setExpirationDate($expiration);
                            $payable->getAccount()->setCurrentParcel($i + 1 . "/" . (int) $parcels);
                            $em->persist($payable);
                            $em->flush();
                        }
                    }
                }
                $this->flashMessenger()->addSuccessMessage('Conta a pagar cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlfinancial/payable');
            } else {
                $this->flashMessenger()->addErrorMessage('Ocorreu um erro ao tentar gravar os dados!');
            }
        }
        return array(
            'form' => $form,
        );
    }

    public function editAction() {
        $personType = $this->params('type', base64_encode(0));
        $id = (int) $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $payable = $em->find($this->getRepository(), $id);
        if (!$payable) {
            return $this->redirect()->toRoute('dtladmin/dtlfinancial/payable/add/' . $personType);
        }
        $form = new PayableForm($em, $this->dtlUserMasterIdentity()->getId());
        $form->bind($payable);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($payable);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Conta a pagar atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlfinancial/payable');
            } else {
                $this->flashMessenger()->addErrorMessage('Ocorreu um erro ao tentar gravar os dados!');
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
            return $this->redirect()->toRoute('dtladmin/dtlfinancial/payable');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $em->remove($em->find($this->getRepository(), $id));
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Conta a pagar apagada com sucesso!');
            }
            return $this->redirect()->toRoute('dtladmin/dtlfinancial/payable');
        }
        return array(
            'id' => $id,
            'payable' => $em->find($this->getRepository(), $id),
        );
    }

    public function viewAction() {
        $id = (int) $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $payable = $em->find($this->getRepository(), $id);
        if (!$payable) {
            return $this->redirect()->toRoute('dtladmin/dtlfinancial/payable');
        }
        return array(
            'id' => $id,
            'payable' => $payable,
        );
    }

    public function dischargeAction() {
        $form = new Discharge($this->getEntityManager());
        $discharge = new \DtlFinancial\Entity\Discharge();
        $form->bind($discharge);
        $request = $this->request;
        if ($request->isPost()) {
            $post = $request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $filter = new \DtlBase\Filter\Currency();
                $dischargeValue = $filter->filter($post->value);
                $account = $em->find('DtlFinancial\Entity\Account', $post->id);
                if ($dischargeValue >= $account->getAccountValue()) {
                    $account->setDone(true);
                } elseif (($dischargeValue > 0) && ($dischargeValue < $account->getValue())) {
                    $accountValue = $account->getValue();
                    $account->setValue($accountValue - $dischargeValue);
                }
                $account->setDoneDate(new \DateTime('now'));
                $account->setDoneValue($dischargeValue);
                $em->persist($account);
                /**
                 * Create a revenue
                 */
                $payable = $em->find($this->getRepository(), $post->id);
                $revenue = new \DtlFinancial\Entity\Revenue();
                $revenue->setUser($this->dtlUserMasterIdentity());
                $revenue->setSupplier($payable->getSupplierId());
                $revenue->getLaunch()->setDate(new \DateTime('now'));
                $revenue->getLaunch()->setValue($dischargeValue);
                $revenue->getLaunch()->setDescription($account->getDescription());
                $em->persist($revenue);
                $em->flush();
                return $this->redirect()->toRoute('dtladmin/dtlfinancial/payable');
            }
        }
    }

    public function getRepository() {
        return $this->repository;
    }

    public function setRepository($repository) {
        $this->repository = $repository;
    }

    /**
     * 
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager($entityManager) {
        $this->entityManager = $entityManager;
    }

}
