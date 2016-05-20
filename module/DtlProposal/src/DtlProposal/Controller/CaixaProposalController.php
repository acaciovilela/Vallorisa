<?php

namespace DtlProposal\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use DtlProposal\Form\CaixaProposal as CaixaProposalForm;
use Zend\View\Model\ViewModel;
use DtlProposal\Service\ProposalService;
use DtlProposal\Service\ProposalSearchQuery;

class CaixaProposalController extends AbstractActionController {

    /**
     *
     * @var \DtlProposal\Service\ProposalService
     */
    protected $proposalService;

    /**
     * @var \DtlProposal\Service\ProposalSession
     */
    protected $proposalSession;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $repository;

    /**
     *
     * @var \DtlProposal\Service\ProposalSearchQuery
     */
    protected $searchQuery;

    public function indexAction() {

        $query = $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->createQueryBuilder('cx')
                ->join('cx.proposal', 'p')
                ->where('p.isActive = TRUE')
                ->orderBy('p.timestamp', 'DESC');

        if ($this->getRequest()->isPost()) {
            $query = $this->searchQuery->caixaProposalSearch($query, $this->getRequest()->getPost());
            $adapter = new DoctrineAdapter(new DoctrinePaginator($query));
            $paginator = new Paginator($adapter);
            if (count($query->getQuery()->getResult()) > 0) {
                $paginator->setDefaultItemCountPerPage(count($query->getQuery()->getResult()));
            } else {
                $paginator->setDefaultItemCountPerPage(10);
            }
        } else {
            $adapter = new DoctrineAdapter(new DoctrinePaginator($query));
            $paginator = new Paginator($adapter);
            $paginator->setDefaultItemCountPerPage(10);
        }

        $page = $this->params()->fromRoute('page');

        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return array(
            'caixaProposal' => $paginator
        );
    }

    public function preAction() {
        $this->getProposalService()->resetSession();
        $form = new \DtlProposal\Form\PreProposal();
        $form->get('cancel')->setAttribute('onclick', "javascript: window.location.href = '/admin/proposal/caixa-proposal';");
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->getProposalSession()->prePost = $this->request->getPost();
                $this->redirect()->toRoute('dtladmin/dtlproposal/caixa-proposal/add');
            } else {
                $form->get('preProposal')->get('personType')->setValue('');
            }
        }
        return array(
            'form' => $form
        );
    }

    public function addAction() {
        $user = $this->identity();
        $form = new CaixaProposalForm($this->getEntityManager(), $this->dtlUserMasterIdentity()->getId());
        $caixa = new \DtlProposal\Entity\CaixaProposal();
        $em = $this->getEntityManager();

        $prePost = $this->getProposalSession()->prePost['preProposal'];

        if (isset($prePost['cpf'])) {
            $document = $prePost['cpf'];
        } else {
            $document = $prePost['cnpj'];
        }

        $customer = $this->findCustomer($document);

        if (null !== $customer && (!$this->request->isPost())) {
            $caixa->getProposal()->setCustomer($customer);
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($caixa, $customer);
        }

        $form->bind($caixa);

        if (null === $customer) {
            $form->get('caixaProposal')->get('proposal')->get('customer')->get('person')->setValue($prePost['type']);
            if (1 === (int) base64_decode($prePost['type'])) {
                $form->get('caixaProposal')->get('proposal')->get('customer')->get('person')->get('legal')->get('cnpj')->setValue($document);
            } else {
                $form->get('caixaProposal')->get('proposal')->get('customer')->get('person')->get('individual')->get('cpf')->setValue($document);
            }
        }
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $sessionContainer = $this->getProposalSession();
                /**
                 * Add Vehicles
                 */
                $products = $sessionContainer->products;

                if (count($products) > 0) {
                    foreach ($products as $productData) {
                        $product = $em->find('DtlProduct\Entity\Product', $productData['product']);
                        $caixa->addProduct($product);
                    }
                }
                $caixa->getProposal()->setUser($user);
                $this->getProposalService()->save($caixa);
                $this->flashMessenger()->addSuccessMessage('Proposta cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/caixa-proposal');
            }
        }

        return array(
            'form' => $form,
            'post' => $this->getProposalSession()->prePost,
            'entityManager' => $this->getEntityManager()
        );
    }

    public function editAction() {
        $caixaId = $this->params()->fromRoute('id');
        $form = new CaixaProposalForm($this->getEntityManager(), $this->dtlUserMasterIdentity()->getId());
        $em = $this->getEntityManager();
        $caixa = $em->find($this->getRepository(), $caixaId);

        if (!$this->request->isPost()) {
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($caixa, $caixa->getProposal()->getCustomer());
        }

        $this->getProposalService()->addProposalProducts($caixa);

        $form->bind($caixa);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $sessionContainer = $this->getProposalSession();
                $products = $sessionContainer->products;
                if (count($products) > 0) {
                    foreach ($products as $productData) {
                        if (!$productData['productId']) {
                            $product = $em->find('DtlProduct\Entity\Product', $productData['productName']);
                            $caixa->addProduct($product);
                        }
                    }
                }
                $this->getProposalService()->update($caixa);
                $this->flashMessenger()->addSuccessMessage('Proposta atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/caixa-proposal');
            }
        }

        return array(
            'form' => $form,
            'caixaProposal' => $caixa,
            'entityManager' => $this->getEntityManager()
        );
    }

    public function deleteAction() {
        $caixaId = $this->params()->fromRoute('id');
        if (!$caixaId) {
            return $this->redirect()->toRoute('dtladmin/dtlproposal/caixa-proposal');
        }
        $em = $this->getEntityManager();
        $caixa = $em->find($this->getRepository(), $caixaId);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $em->remove($caixa);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Proposta apagada com sucesso!');
            } else {
                $this->flashMessenger()->addInfoMessage('Nenhuma alteração foi gravada!');
            }
            return $this->redirect()->toRoute('dtladmin/dtlproposal/caixa-proposal');
        }
        return array(
            'id' => $caixaId,
            'customer' => $caixa->getProposal()->getCustomer()
        );
    }

    public function viewAction() {
        $caixaId = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $caixa = $em->find('DtlProposal\Entity\CaixaProposal', $caixaId);
        return array(
            'caixaProposal' => $caixa,
        );
    }

    public function historyAction() {
        $caixaId = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $caixa = $em->find('DtlProposal\Entity\CaixaProposal', $caixaId);
        return array(
            'caixaProposal' => $caixa,
        );
    }

    public function statusAction() {
        $caixaId = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $caixa = $em->find('DtlProposal\Entity\CaixaProposal', $caixaId);

        if ($caixa->getProposal()->getIsRefused()) {
            return array(
                'refused' => true,
                'caixaProposal' => $caixa,
            );
        }

        $form = new \DtlProposal\Form\ProposalStatus($em);
        $form->bind($caixa->getProposal());
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->getProposalService()->changeStatus($caixa, $this->request->getPost()->proposalStatus);
                $this->flashMessenger()->addSuccessMessage('Status da proposta alterado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/caixa-proposal');
            }
        }

        return array(
            'form' => $form,
            'caixaProposal' => $caixa,
        );
    }

    public function listproductsAction() {
        $products = array();
        if (!empty($this->getProposalSession()->products)) {
            $products = $this->getProposalSession()->products;
        }
        $view = new ViewModel(array(
            'products' => $products,
        ));
        $view->setTemplate('dtl-proposal/caixa-proposal/caixa/listcaixa');
        return $view;
    }

    public function addproductAction() {
        if (!$this->getProposalSession()->products) {
            $this->getProposalSession()->products = array();
        }
        $product = $this->params()->fromQuery();

        if (empty($product['product'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        } else {
            $em = $this->getEntityManager();
            $item = $em->find('DtlProduct\Entity\Product', $product['product']);
            $product['productName'] = $item->getName();
            $this->getProposalSession()->products[] = $product;
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

    public function deleteproductAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $products = $this->getProposalSession()->products;
        if ($item >= 0) {
            unset($products[$item]);
            $this->getProposalSession()->products = $products;
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
    }

    public function searchAction() {
        $form = new \DtlProposal\Form\Search($this->getEntityManager(), $this->identity()->getId());
        return new ViewModel(array(
            'form' => $form,
        ));
    }

    public function exportCsvAction() {
        $header = array(
            'CÓD',
            'CLIENTE',
            'CPF/CNPJ',
            'DATA DE CADASTRO',
            'VALOR FINANCIADO',
            'PARCELAS',
            'BANCO',
            'ENDEREÇO',
            'NUMERO',
            'BAIRRO',
            'CIDADE',
            'ESTADO',
            'EMAIL',
            'TELEFONE',
            'CELULAR',
        );

        $em = $this->getEntityManager();
        $query = $em->getRepository($this->getRepository())
                ->createQueryBuilder('cp')
                ->select('cp.id, p.name, p.type, l.cnpj, '
                        . 'pr.date, pr.value, pr.parcelAmount, '
                        . 'b.name as bankName, '
                        . 'i.cpf, a.name as addressName, a.number, '
                        . 'a.quarter, cy.name as city, st.name as state, '
                        . 'ct.email, ct.phone, ct.cell')
                ->join('cp.proposal', 'pr')
                ->join('pr.bank', 'b')
                ->join('pr.customer', 'c')
                ->join('c.person', 'p')
                ->join('p.address', 'a')
                ->join('a.city', 'cy')
                ->join('a.state', 'st')
                ->join('p.contact', 'ct')
                ->leftJoin('p.legal', 'l')
                ->leftJoin('p.individual', 'i')
                ->where('pr.isActive = true')
                ->orderBy('p.name', 'ASC')
                ->getQuery();

        $proposals = $query->getResult();

        $data = array();
        foreach ($proposals as $proposal) {
            if ($proposal['type']) {
                $person_doc = $proposal['cnpj'];
            } else {
                $person_doc = $proposal['cpf'];
            }
            $data[] = array(
                $proposal['id'],
                $proposal['name'],
                $person_doc,
                $proposal['date'],
                $proposal['value'],
                $proposal['parcelAmount'],
                $proposal['bankName'],
                $proposal['addressName'],
                $proposal['number'],
                $proposal['quarter'],
                $proposal['city'],
                $proposal['state'],
                $proposal['email'],
                $proposal['phone'],
                $proposal['cell'],
            );
        }

        return $this->csvExport('propostas_caixa_' . date('dmYHis'), $header, $data, null, ';');
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function setRepository($repository) {
        $this->repository = $repository;
        return $this;
    }

    public function getProposalSession() {
        return $this->proposalSession;
    }

    public function setProposalSession($proposalSession) {
        $this->proposalSession = $proposalSession;
        return $this;
    }

    public function getProposalService() {
        return $this->proposalService;
    }

    public function setProposalService(ProposalService $proposalService) {
        $this->proposalService = $proposalService;
        return $this;
    }

    public function getSearchQuery() {
        return $this->searchQuery;
    }

    public function setSearchQuery(ProposalSearchQuery $searchQuery) {
        $this->searchQuery = $searchQuery;
        return $this;
    }

}
