<?php

namespace DtlProposal\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use DtlProposal\Form\CaixaProposal as CaixaProposalForm;
use Zend\View\Model\ViewModel;

class CaixaProposalController extends AbstractActionController {

    /**
     *
     * @var \DtlProposal\Service\Proposal
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

        $userId = $this->identity()->getId();

        $form = new CaixaProposalForm($this->getEntityManager(), $userId);

        $caixaProposal = new \DtlProposal\Entity\CaixaProposal();

        $em = $this->getEntityManager();

        $digitsFilter = new \Zend\Filter\Digits();

        /**
         * Find Customer if exists
         */
        $prePost = $this->getProposalSession()->prePost['preProposal'];

        if (!empty($prePost['cpf'])) {
            $personDocument = $prePost['cpf'];
        } else {
            $personDocument = $prePost['cnpj'];
        }

        $personDocument = $digitsFilter->filter($personDocument);

        $personType = base64_decode($prePost['type']);

        if ($prePost['type'] == base64_encode(0)) {

            $result = $em->getRepository('DtlCustomer\Entity\Customer')
                    ->createQueryBuilder('c')
                    ->Join('c.person', 'p')
                    ->leftJoin('p.individual', 'i')
                    ->where('i.cpf = ' . $personDocument)
                    ->andWhere('c.isActive = true')
                    ->getQuery()
                    ->getOneOrNullResult();
        } else {
            $result = $em->getRepository('DtlCustomer\Entity\Customer')
                    ->createQueryBuilder('c')
                    ->Join('c.person', 'p')
                    ->leftJoin('p.legal', 'l')
                    ->where('l.cnpj = ' . $personDocument)
                    ->andWhere('c.isActive = true')
                    ->getQuery()
                    ->getOneOrNullResult();
        }

        if ($result && (!$this->request->isPost())) {

            $caixaProposal->getProposal()->setCustomer($result);

            $this->getProposalService()->resetSession();

            $this->getProposalService()->populate($result);
        }

        $form->bind($caixaProposal);

        $form->get('caixaProposal')
                ->get('proposal')
                ->get('customer')
                ->get('person')->setValue($personType);

        if ($personType) {
            $form->get('caixaProposal')
                    ->get('proposal')
                    ->get('customer')
                    ->get('person')
                    ->get('legal')
                    ->get('cnpj')
                    ->setValue($personDocument);
        } else {
            $form->get('caixaProposal')
                    ->get('proposal')
                    ->get('customer')
                    ->get('person')
                    ->get('individual')
                    ->get('cpf')
                    ->setValue($personDocument);
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
                        $product = $em->find('Product\Entity\Product', $productData['product']);
                        $caixaProposal->addProduct($product);
                    }
                }

                $customer = $caixaProposal->getProposal()->getCustomer();

                $customer->setUser($userId);

                $this->getProposalService()->addCustomerBankAccount($customer);

                $this->getProposalService()->addCustomerReference($customer);

                $this->getProposalService()->addCustomerPatrimony($customer);

                $this->getProposalService()->addCustomerVehicle($customer);

                $em->persist($customer);

                $caixaProposal->getProposal()->setCustomer($customer);

                /**
                 * Resume routines
                 */
                $bank = $em->find('DtlBank\Entity\Bank', $post->caixaProposal['proposal']['bank']);

                $log = new \DtlProposal\Entity\Log();
                $log->setBank($bank);
                $log->setMessage('ABERTA: PROPOSTA EM ANÁLISE');
                $em->persist($log);
                $caixaProposal->getProposal()->addLog($log);

                $em->persist($caixaProposal);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Proposta cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/caixa-proposal');
            }
        }

        return array(
            'form' => $form,
            'post' => $this->getProposalSession()->prePost,
            'entityManager' => $this->getEntityManager(),
            'userId' => $userId,
        );
    }

    public function editAction() {
        $proposalId = $this->params()->fromRoute('id');

        $userId = $this->identity()->getId();

        $form = new CaixaProposalForm($this->getEntityManager(), $userId);

        $em = $this->getEntityManager();

        $caixaProposal = $em->find($this->getRepository(), $proposalId);

        if (!$this->request->isPost()) {
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($caixaProposal->getProposal()->getCustomer());
        }

        $this->getProposalService()->addProposalProducts($caixaProposal);

        $form->bind($caixaProposal);

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
                        if (!$productData['id']) {
                            $product = $em->find('DtlProduct\Entity\Product', $productData['product']);
                            $caixaProposal->addProduct($product);
                        }
                    }
                }

                $customer = $caixaProposal->getProposal()->getCustomer();

                $this->getProposalService()->addCustomerBankAccount($customer);

                $this->getProposalService()->addCustomerReference($customer);

                $this->getProposalService()->addCustomerPatrimony($customer);

                $this->getProposalService()->addCustomerVehicle($customer);

                $em->persist($customer);

                $caixaProposal->getProposal()->setCustomer($customer);

                /**
                 * Resume routines
                 */
                $bank = $em->find('DtlBank\Entity\Bank', $post->caixaProposal['proposal']['bank']);

                $log = new \DtlProposal\Entity\Log();
                $log->setBank($bank);
                $log->setMessage('ATUALIZAÇÃO: PROPOSATA ATUALIZADA.');
                $em->persist($log);
                $caixaProposal->getProposal()->addLog($log);

                $em->persist($caixaProposal);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Proposta atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/caixa-proposal');
            }
        }

        return array(
            'form' => $form,
            'caixaProposal' => $caixaProposal,
            'entityManager' => $this->getEntityManager(),
            'companyId' => $userId,
        );
    }

    public function deleteAction() {
        $caixaProposalId = $this->params()->fromRoute('id');
        if (!$caixaProposalId) {
            return $this->redirect()->toRoute('dtladmin/dtlproposal/caixa-proposal');
        }
        $em = $this->getEntityManager();
        $caixaProposal = $em->find($this->getRepository(), $caixaProposalId);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $em->remove($caixaProposal);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Proposta apagada com sucesso!');
            } else {
                $this->flashMessenger()->addInfoMessage('Nenhuma alteração foi gravada!');
            }
            return $this->redirect()->toRoute('dtladmin/dtlproposal/caixa-proposal');
        }
        return array(
            'id' => $caixaProposalId,
            'customer' => $caixaProposal->getProposal()->getCustomer()
        );
    }

    public function viewAction() {
        $caixaProposalId = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();

        $caixaProposal = $em->find('DtlProposal\Entity\CaixaProposal', $caixaProposalId);

        return array(
            'caixaProposal' => $caixaProposal,
        );
    }

    public function historyAction() {
        $caixaProposalId = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();

        $caixaProposal = $em->find('DtlProposal\Entity\CaixaProposal', $caixaProposalId);

        return array(
            'caixaProposal' => $caixaProposal,
        );
    }

    public function statusAction() {

        $caixaProposalId = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();

        $caixaProposal = $em->find('DtlProposal\Entity\CaixaProposal', $caixaProposalId);

        if ($caixaProposal->getProposal()->getIsRefused()) {
            return array(
                'refused' => true,
                'caixaProposal' => $caixaProposal,
            );
        }

        $form = new \DtlProposal\Form\ProposalStatus();

        if ($this->request->isPost()) {

            $form->setData($this->request->getPost());

            if ($form->isValid()) {

                $post = $this->request->getPost()->proposalStatus;

                switch ($post['proposalStatusId']) {
                    case 'APPROVED':
                        $data = array(
                            'isApproved' => true,
                            'isChecking' => false,
                            'isCanceled' => false,
                            'isIntegrated' => false,
                            'isRefused' => false,
                            'isAborted' => false,
                            'isPending' => false,
                            'lastChange' => date('Y-m-d H:i:s'),
                        );
                        $data_log = array(
                            'timestamp' => date('Y-m-d H:i:s'),
                            'message' => 'APROVADA: ' . $post['proposalStatusNotes'],
                            'bank' => $caixaProposal->getProposal()->getBank(),
                        );
                        break;
                    case 'ABORTED':
                        $data = array(
                            'isApproved' => false,
                            'isChecking' => false,
                            'isCanceled' => false,
                            'isIntegrated' => false,
                            'isRefused' => false,
                            'isAborted' => true,
                            'isPending' => false,
                            'lastChange' => date('Y-m-d H:i:s'),
                        );
                        $data_log = array(
                            'timestamp' => date('Y-m-d H:i:s'),
                            'message' => 'ABORTADA: ' . $post['proposalStatusNotes'],
                            'bank' => $caixaProposal->getProposal()->getBank(),
                        );
                        break;
                    case 'CHECKING':
                        $data = array(
                            'isApproved' => false,
                            'isChecking' => true,
                            'isCanceled' => false,
                            'isIntegrated' => false,
                            'isRefused' => false,
                            'isAborted' => false,
                            'isPending' => false,
                            'lastChange' => date('Y-m-d H:i:s'),
                        );
                        $data_log = array(
                            'timestamp' => date('Y-m-d H:i:s'),
                            'message' => 'ABERTA: ' . $post['proposalStatusNotes'],
                            'bank' => $caixaProposal->getProposal()->getBank(),
                        );
                        break;
                    case 'CHECKING_IN':
                        $data = array(
                            'isApproved' => false,
                            'isChecking' => true,
                            'isCanceled' => false,
                            'isIntegrated' => false,
                            'isRefused' => false,
                            'isAborted' => false,
                            'isPending' => false,
                            'lastChange' => date('Y-m-d H:i:s'),
                        );
                        $data_log = array(
                            'timestamp' => date('Y-m-d H:i:s'),
                            'message' => 'ABERTA (MOVIMENTAÇÃO): ' . $post['proposalStatusNotes'],
                            'bank' => $caixaProposal->getProposal()->getBank(),
                        );
                        break;
                    case 'CANCELED':
                        $data = array(
                            'isApproved' => false,
                            'isChecking' => false,
                            'isCanceled' => true,
                            'isIntegrated' => false,
                            'isRefused' => false,
                            'isAborted' => false,
                            'isPending' => false,
                            'lastChange' => date('Y-m-d H:i:s'),
                        );
                        $data_log = array(
                            'timestamp' => date('Y-m-d H:i:s'),
                            'message' => 'CANCELADA: ' . $post['proposalStatusNotes'],
                            'bank' => $caixaProposal->getProposal()->getBank(),
                        );
                        break;
                    case 'REFUSED':
                        $data = array(
                            'isApproved' => false,
                            'isChecking' => false,
                            'isCanceled' => false,
                            'isIntegrated' => false,
                            'isRefused' => true,
                            'isAborted' => false,
                            'isPending' => false,
                            'lastChange' => date('Y-m-d H:i:s'),
                        );
                        $data_log = array(
                            'timestamp' => date('Y-m-d H:i:s'),
                            'message' => 'RECUSADA: ' . $post['proposalStatusNotes'],
                            'bank' => $caixaProposal->getProposal()->getBank(),
                        );
                        break;
                    case 'INTEGRATED':
                        $data = array(
                            'isApproved' => false,
                            'isChecking' => false,
                            'isCanceled' => false,
                            'isIntegrated' => true,
                            'isRefused' => false,
                            'isAborted' => false,
                            'isPending' => false,
                            'lastChange' => date('Y-m-d H:i:s'),
                        );
                        $data_log = array(
                            'timestamp' => date('Y-m-d H:i:s'),
                            'message' => 'INTEGRADA: ' . $post['proposalStatusNotes'],
                            'bank' => $caixaProposal->getProposal()->getBank(),
                        );

                        /**
                         * Generates commissions
                         */
                        $proposalValue = $caixaProposal->getProposal()->getValue();
                        $products = $caixaProposal->getProducts();
                        $employee = $caixaProposal->getProposal()->getEmployee();

                        $comm = 0;
                        $empCommission = 0;

                        if (count($products)) {
                            foreach ($products as $product) {
                                $fixCom = $product->getFixedCommission();
                                $varCom = $product->getVariantCommission();
                                $commissionCalc = (($proposalValue * $varCom) / 100) + $fixCom;
                                $comm += $commissionCalc;
                                if ($employee) {
                                    $empCommissions = $employee->getCommissions();
                                    if (count($empCommissions)) {
                                        foreach ($empCommissions as $empComm) {
                                            if ($empComm->getProduct() === $product) {
                                                $empFixCom = $empComm->getEmployeeCommissionFixed();
                                                $empVarCom = $empComm->getEmployeeCommissionVariant();
                                                $empCommission += (($commissionCalc * $empVarCom) / 100) + $empFixCom;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        /**
                         * Company commissions
                         */
                        $commission = number_format($comm, 2);
                        $receivable = $this->getServiceLocator()->get('financial_create_receivable');
                        $receivable->setCompany($caixaProposal->getProposal()->getCompany());
                        $receivable->setCustomer($caixaProposal->getProposal()->getCustomer());
                        $receivable->setDescription("COM. REF. A PROPOSTA CAIXA Nº {$caixaProposal->getCaixaProposalId()}");
                        $receivable->setValue($commission);
                        $receivable->create();

                        /**
                         * Employee commissions
                         */
                        $employeeCommission = number_format($empCommission, 2);
                        $supplier = $employee->getSupplier();
                        $payable = $this->getServiceLocator()->get('financial_create_payable');
                        $payable->setCompany($caixaProposal->getProposal()->getCompany());
                        $payable->setSupplier($supplier);
                        $payable->setDescription("COM. REF. A PROPOSTA CAIXA Nº {$caixaProposal->getCaixaProposalId()}.");
                        $payable->setValue($employeeCommission);
                        $payable->create();

                        break;
                    case 'PENDING':
                        $data = array(
                            'isApproved' => false,
                            'isChecking' => false,
                            'isCanceled' => false,
                            'isIntegrated' => false,
                            'isRefused' => false,
                            'isAborted' => false,
                            'isPending' => true,
                            'lastChange' => date('Y-m-d H:i:s'),
                        );
                        $data_log = array(
                            'timestamp' => date('Y-m-d H:i:s'),
                            'message' => 'PENDENTE: ' . $post['proposalStatusNotes'],
                            'bank' => $caixaProposal->getProposal()->getBank(),
                        );
                        break;
                }

                $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);

                $proposal = $caixaProposal->getProposal();
                $hydrator->hydrate($data, $proposal);

                if ($post['proposalStatusId'] == "INTEGRATED") {
                    if ($post['proposalStatusBaseDate']) {
                        $dateFilter = new \DtlBase\Filter\Date();
                        $date = new \DateTime($dateFilter->filter($post['proposalStatusBaseDate']));
                        $timestamp = $date->getTimestamp();

                        $startDate = $date->setDate(date('Y', $timestamp), date('m', $timestamp) + 1, date('d', $timestamp));

                        $date = new \DateTime($dateFilter->filter($post['proposalStatusBaseDate']));

                        $endDate = $date->setDate(date('Y', $timestamp), date('m', $timestamp) + $proposal->getParcelAmount() + 1, date('d', $timestamp));

                        $baseDate = date('Y-m-d', $timestamp);

                        $data = array(
                            'proposalBaseDate' => $baseDate,
                            'proposalStartDate' => $startDate,
                            'proposalEndDate' => $endDate
                        );

                        $hydrator->hydrate($data, $proposal);
                    }
                }

                if ($post['proposalStatusId'] == 'APPROVED') {
                    $currencyFilter = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));
                    $caixaProposalTotalValue = $caixaProposal->getCaixaProposalTotalValue();
                    $proposalParcelAmount = $post['proposalStatusParcelAmount'];
                    $proposalParcelValue = $currencyFilter->filter($post['proposalStatusParcelValue']);
                    $proposalValue = $currencyFilter->filter($post['proposalStatusValue']);
                    $caixaProposalInValue = $caixaProposalTotalValue - $proposal->getValue();

                    if (!empty($proposalParcelAmount) && !empty($proposalParcelValue) && !empty($proposalValue)) {
                        $data = array(
                            'proposalParcelAmount' => $proposalParcelAmount,
                            'proposalParcelValue' => $proposalParcelValue,
                            'proposalValue' => $proposalValue,
                        );

                        $hydrator->hydrate($data, $proposal);
                        $caixaProposal->setCaixaProposalInValue($caixaProposalInValue);
                    }
                }

                $log = new \DtlProposal\Entity\Log();
                $hydrator->hydrate($data_log, $log);
                $proposal->addLog($log);

                $em->persist($proposal);
                $em->persist($caixaProposal);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Status da proposta alterado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/caixa-proposal');
            }
        }

        return array(
            'form' => $form,
            'caixaProposal' => $caixaProposal,
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
            $item = $em->find('Product\Entity\Product', $product['product']);
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
                ->createQueryBuilder('rp')
                ->select('rp.caixaProposalId, p.name, p.type, l.cnpj, '
                        . 'pr.date, pr.value, pr.parcelAmount, '
                        . 'b.bankName, '
                        . 'i.cpf, a.name, a.number, '
                        . 'a.quarter, a.city, a.state, '
                        . 'ct.email, ct.phone, ct.cell')
                ->join('rp.proposal', 'pr')
                ->join('pr.bank', 'b')
                ->join('pr.customer', 'c')
                ->join('c.person', 'p')
                ->join('p.address', 'a')
                ->join('p.contact', 'ct')
                ->leftJoin('p.legal', 'l')
                ->leftJoin('p.individual', 'i')
                ->where('pr.proposalIsActive = true')
                ->orderBy('p.name', 'ASC')
                ->getQuery();

        $proposals = $query->getResult();

        $data = array();

        foreach ($proposals as $proposal) {
            if ($proposal['personType']) {
                $person_doc = $proposal['cnpj'];
            } else {
                $person_doc = $proposal['cpf'];
            }
            $data[] = array(
                $proposal['caixaProposalId'],
                $proposal['personName'],
                $person_doc,
                $proposal['proposalDate'],
                $proposal['proposalValue'],
                $proposal['proposalParcelAmount'],
                $proposal['bankName'],
                $proposal['addressName'],
                $proposal['addressNumber'],
                $proposal['addressQuarter'],
                $proposal['addressCity'],
                $proposal['addressState'],
                $proposal['contactEmail'],
                $proposal['contactPhone'],
                $proposal['contactCell'],
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

    public function setProposalService(\DtlProposal\Service\Proposal $proposalService) {
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
