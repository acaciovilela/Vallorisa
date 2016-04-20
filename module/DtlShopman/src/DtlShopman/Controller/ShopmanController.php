<?php

namespace DtlShopman\Controller;

use DtlShopman\Entity\Shopman as ShopmanEntity;
use DtlShopman\Form\Shopman as ShopmanForm;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use Zend\Json\Json;

class ShopmanController extends AbstractActionController {

    protected $repository;
    protected $entityManager;

    public function indexAction() {

        $query = $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->createQueryBuilder('s')
                ->join('s.person', 'p')
                ->where('s.user = ' . $this->dtlUserMasterIdentity()->getId())
                ->andwhere('s.isActive = TRUE')
                ->orderBy('p.name', 'ASC');

        if ($this->request->isPost()) {
            $formSearch = $this->getRequest()->getPost();
            if (!empty($formSearch->shopman_cod_search)) {
                $query->andWhere("s.id = :cod");
                $query->setParameter('cod', $formSearch->shopman_cod_search);
            } elseif (!empty($formSearch->shopman_name_search)) {
                $query->andWhere("p.name LIKE :name");
                $query->setParameter('name', $formSearch->shopman_name_search . '%');
            } elseif (!empty($formSearch->shopman_doc_search)) {
                $docNumber = trim($formSearch->shopman_doc_search);
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

        $form = new \DtlShopman\Form\ShopmanProduct($this->getEntityManager());

        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return array(
            'shopman' => $paginator,
            'form' => $form,
        );
    }

    public function addAction() {
        $personType = $this->params('type', base64_encode(0));
        $form = new ShopmanForm($this->getEntityManager());
        $shopman = new ShopmanEntity();
        $shopman->getPerson()->setType(base64_decode($personType));
        $form->bind($shopman);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($shopman);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Lojista cadastrado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlshopman');
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
            return $this->redirect()->toRoute('dtladmin/dtlshopman/add/' . $personType);
        }
        $form = new ShopmanForm($this->getEntityManager());
        $form->bind($item);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($item);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Lojista atualizado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlshopman');
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
            return $this->redirect()->toRoute('dtladmin/dtlshopman');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $id = $request->getPost('id');
                $shopman = $em->find($this->getRepository(), $id);
                $shopman->setIsActive(false);
                $em->persist($shopman);
                $em->flush();
            }
            $this->flashMessenger()->addSuccessMessage('Lojista apagado com sucesso!');
            return $this->redirect()->toRoute('dtladmin/dtlshopman');
        }
        return array(
            'id' => $id,
            'shopman' => $em->find($this->getRepository(), $id),
        );
    }

    public function viewAction() {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        $em = $this->getEntityManager();
        $item = $em->getRepository($this->getRepository())->findOneBy(array('id' => $id));
        if (!$item) {
            return $this->redirect()->toRoute('dtladmin/dtlshopman');
        }
        return array(
            'id' => $id,
            'shopman' => $em->find($this->getRepository(), $id),
        );
    }

    public function fillAction() {
        $shopmanId = (int) $this->params()->fromQuery('itemId');
        $em = $this->getEntityManager();
        $shopman = $em->find($this->getRepository(), $shopmanId);
        $sellers = $shopman->getSellers();
        $options = '';
        foreach ($sellers as $seller) {
            $options .= '<option value="' . $seller->getId() . '">' . $seller->getPerson()->getName() . '</option>';
        }
        return $this->getResponse()->setContent(Json::encode(array('options' => $options)));
    }

    public function fillproductAction() {
        $id = (int) $this->params()->fromQuery('itemId');
        $em = $this->getEntityManager();
        $shopman = $em->find($this->getRepository(), $id);
        $product = $shopman->getProducts();
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
