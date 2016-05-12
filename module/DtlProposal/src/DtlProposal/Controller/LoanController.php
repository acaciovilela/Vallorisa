<?php

namespace DtlProposal\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use DtlProposal\Form\Loan as LoanForm;
use Zend\View\Model\ViewModel;

class LoanController extends AbstractActionController {

    /**
     *
     * @var \DtlProposal\Service\Proposal
     */
    protected $proposalService;

    /**
     *
     * @var \DtlProposal\Service\Proposal
     */
    protected $proposalSession;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var \DtlProposal\Entity\Loan
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
                ->createQueryBuilder('l')
                ->join('l.proposal', 'p')
                ->where('p.isActive = TRUE')
                ->orderBy('p.timestamp', 'DESC');

        if ($this->getRequest()->isPost()) {
            $query = $this->searchQuery->loanProposalSearch($query, $this->request->getPost());
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
            'loan' => $paginator
        );
    }

    public function preAction() {
        $this->getProposalService()->resetSession();
        $form = new \DtlProposal\Form\PreProposal();
        $form->get('cancel')->setAttribute('onclick', "javascript: window.location.href = '/admin/proposal/loan';");
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->getProposalSession()->prePost = $this->request->getPost();
                $this->redirect()->toRoute('dtladmin/dtlproposal/loan/add');
            } else {
                $form->get('preProposal')->get('type')->setValue('');
            }
        }
        return array(
            'form' => $form
        );
    }

    public function addAction() {
        $user = $this->identity();
        $form = new LoanForm($this->getEntityManager(), $this->dtlUserMasterIdentity()->getId());
        $loan = new \DtlProposal\Entity\Loan();

        $prePost = $this->getProposalSession()->prePost['preProposal'];

        if (isset($prePost['cpf'])) {
            $document = $prePost['cpf'];
        } else {
            $document = $prePost['cnpj'];
        }

        $customer = $this->findCustomer($document);

        if ($customer && (!$this->request->isPost())) {
            $customer->setUser($user);
            $loan->getProposal()->setCustomer($customer);
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($loan, $customer);
        }

        $form->bind($loan);
        $form->get('loan')->get('proposal')->get('customer')->get('person')->setValue($prePost['type']);
        if ($prePost['type']) {
            $form->get('loan')->get('proposal')->get('customer')->get('person')->get('legal')->get('cnpj')->setValue($document);
        } else {
            $form->get('loan')->get('proposal')->get('customer')->get('person')->get('individual')->get('cpf')->setValue($document);
        }
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $loan->getProposal()->setUser($user);
                $this->getProposalService()->save($loan);
                $this->flashMessenger()->addSuccessMessage('Proposta cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/loan');
            }
        }

        return array(
            'form' => $form,
            'post' => $this->getProposalSession()->prePost,
            'entityManager' => $this->getEntityManager()
        );
    }

    public function editAction() {
        $loanId = $this->params()->fromRoute('id');
        $form = new LoanForm($this->getEntityManager(), $this->dtlUserMasterIdentity()->getId());
        $em = $this->getEntityManager();
        $loan = $em->find($this->getRepository(), $loanId);

        if (!$this->request->isPost()) {
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($loan, $loan->getProposal()->getCustomer());
        }

        $form->bind($loan);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $this->getProposalService()->update($loan);
                $this->flashMessenger()->addSuccessMessage('Proposta atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/loan');
            }
        }

        return array(
            'form' => $form,
            'loan' => $loan,
            'entityManager' => $this->getEntityManager()
        );
    }

    public function deleteAction() {
        $loanId = $this->params()->fromRoute('id');
        if (!$loanId) {
            return $this->redirect()->toRoute('dtladmin/dtlproposal/loan');
        }
        $em = $this->getEntityManager();
        $loan = $em->find($this->getRepository(), $loanId);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $em->remove($loan);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Proposta apagada com sucesso!');
            } else {
                $this->flashMessenger()->addInfoMessage('Nenhuma alteração foi gravada.!');
            }
            return $this->redirect()->toRoute('dtladmin/dtlproposal/loan');
        }
        return array(
            'id' => $loanId,
            'customer' => $loan->getProposal()->getCustomer()
        );
    }

    public function viewAction() {
        $loanId = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $loan = $em->find('DtlProposal\Entity\Loan', $loanId);
        return array(
            'loan' => $loan,
        );
    }

    public function historyAction() {
        $loanId = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $loan = $em->find('DtlProposal\Entity\Loan', $loanId);
        return array(
            'loan' => $loan,
        );
    }

    public function statusAction() {
        $loanId = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $loan = $em->find('DtlProposal\Entity\Loan', $loanId);

        if ($loan->getProposal()->getIsRefused()) {
            return array(
                'refused' => true,
                'loan' => $loan,
            );
        }

        $form = new \DtlProposal\Form\ProposalStatus($em);
        $form->bind($loan->getProposal());
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->getProposalService()->changeStatus($loan, $this->request->getPost()->proposalStatus);
                $this->flashMessenger()->addSuccessMessage('Status da proposta alterado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/loan');
            }
        }

        return array(
            'form' => $form,
            'loan' => $loan,
        );
    }

    public function bankAction() {
        $loanId = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $loan = $em->find('DtlProposal\Entity\Loan', $loanId);

        if ($loan->getProposal()->getIsChecking()) {
            return array(
                'checking' => true,
                'loan' => $loan,
            );
        }

        $form = new \DtlProposal\Form\BankReport($em);
        $form->get('bankReport')->get('parcelAmount')->setValue($loan->getProposal()->getParcelAmount());
        $form->get('bankReport')->get('parcelValue')->setValue($loan->getProposal()->getParcelValue());

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->getProposalService()->changeBank($loan, $this->request->getPost()->bankReport);
                $this->flashMessenger()->addSuccessMessage('Migração bancária efetuada com sucesso na proposta nº ' . $loan->getId() . ' com sucesso!');
                return $this->redirect()->toRoute("dtladmin/dtlproposal/loan");
            }
        }

        return array(
            'form' => $form,
            'loan' => $loan,
        );
    }

    public function calculateAction() {

        $params = $this->params()->fromQuery();

        $result = $this->getProposalService()->calculate($params);

        return $this->response->setContent(\Zend\Json\Json::encode($result));
    }

    private function populate($loan, $customer) {
        $this->getProposalService()->populate($loan, $customer);
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
                ->createQueryBuilder('lp')
                ->select('(lp.id) as id, p.name, p.type, l.cnpj, '
                        . 'pr.date, pr.value, pr.parcelAmount, '
                        . 'b.name as bankName, '
                        . 'i.cpf, a.name addressName, a.number, '
                        . 'a.quarter, ci.name as city, st.name as state, '
                        . 'ct.email, ct.phone, ct.cell')
                ->join('lp.proposal', 'pr')
                ->join('pr.bank', 'b')
                ->join('pr.customer', 'c')
                ->join('c.person', 'p')
                ->join('p.address', 'a')
                ->join('a.state', 'st')
                ->join('a.city', 'ci')
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

        return $this->csvExport('propostas_consignado_' . date('dmYHis'), $header, $data, null, ';');
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

    public function setProposalService($proposalService) {
        $this->proposalService = $proposalService;
        return $this;
    }

    public function getSearchQuery() {
        return $this->searchQuery;
    }

    public function setSearchQuery(\DtlProposal\Service\ProposalSearchQuery $searchQuery) {
        $this->searchQuery = $searchQuery;
        return $this;
    }

}
