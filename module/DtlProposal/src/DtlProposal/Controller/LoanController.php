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
                ->createQueryBuilder('l')
                ->join('l.proposal', 'p')
                ->where('p.isActive = TRUE')
                ->orderBy('p.timestamp', 'DESC');

        if ($this->getRequest()->isPost()) {
            $query = $this->searchQuery->loanProposalSearch($query, $this->getRequest()->getPost());
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

            $loan->getProposal()->setCustomer($result);

            $this->getProposalService()->resetSession();

            $this->getProposalService()->populate($result);
        }

        $form->bind($loan);

        $form->get('loan')
                ->get('proposal')
                ->get('customer')
                ->get('person')->setValue($personType);

        if ($personType) {
            $form->get('loan')
                    ->get('proposal')
                    ->get('customer')
                    ->get('person')
                    ->get('legal')
                    ->get('cnpj')
                    ->setValue($personDocument);
        } else {
            $form->get('loan')
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

                $customer = $loan->getProposal()->getCustomer();

                $customer->setUser($user);

                $this->getProposalService()->addCustomerBankAccount($customer);

                $this->getProposalService()->addCustomerReference($customer);

                $this->getProposalService()->addCustomerPatrimony($customer);

                $this->getProposalService()->addCustomerVehicle($customer);

                $em->persist($customer);

                $loan->getProposal()->setCustomer($customer);
                /**
                 * Resume routines
                 */
                $bank = $em->find('DtlBank\Entity\Bank', $post->loan['proposal']['bank']);
                $bankReport = new \DtlProposal\Entity\BankReport();
                $bankReport->setIsActive(true);
                $bankReport->setBank($bank);
                $em->persist($bankReport);
                $loan->getProposal()->addReport($bankReport);

                $log = new \DtlProposal\Entity\Log();
                $log->setBank($bank);
                $log->setMessage('ABERTA: PROPOSTA EM ANÁLISE');
                $em->persist($log);
                $loan->getProposal()->addLog($log);

                $em->persist($loan);

                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Proposta cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/loan');
            }
        }

        return array(
            'form' => $form,
            'post' => $this->getProposalSession()->prePost,
            'entityManager' => $this->getEntityManager(),
            'userId' => $user->getId(),
        );
    }

    public function editAction() {
        $proposalId = $this->params()->fromRoute('id');

        $userId = $this->identity()->getId();

        $form = new LoanForm($this->getEntityManager(), $userId);

        $em = $this->getEntityManager();

        $loan = $em->find($this->getRepository(), $proposalId);
        
//        \Zend\Debug\Debug::dump($loan->getBenefitNumber());exit;

        if (!$this->request->isPost()) {
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($loan->getProposal()->getCustomer());
        }

        $form->bind($loan);

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $customer = $loan->getProposal()->getCustomer();

                $this->getProposalService()->addCustomerBankAccount($customer);

                $this->getProposalService()->addCustomerReference($customer);

                $this->getProposalService()->addCustomerPatrimony($customer);

                $this->getProposalService()->addCustomerVehicle($customer);

                $em->persist($customer);

                /**
                 * Resume routines
                 */
                $bank = $em->find('DtlBank\Entity\Bank', $post->loan['proposal']['bank']);
                $log = new \DtlProposal\Entity\Log();
                $log->setBank($bank);
                $log->setMessage('ATUALIZAÇÃO: PROPOSTA ATUALIZADA!');
                $em->persist($log);
                $loan->getProposal()->addLog($log);

                $em->persist($loan);

                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Proposta atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/loan');
            }
        }

        return array(
            'form' => $form,
            'loan' => $loan,
            'entityManager' => $this->getEntityManager(),
            'companyId' => $userId,
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
                            'bank' => $loan->getProposal()->getBank(),
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
                            'bank' => $loan->getProposal()->getBank(),
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
                            'bank' => $loan->getProposal()->getBank(),
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
                            'bank' => $loan->getProposal()->getBank(),
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
                            'bank' => $loan->getProposal()->getBank(),
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
                            'bank' => $loan->getProposal()->getBank(),
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
                            'bank' => $loan->getProposal()->getBank(),
                        );

                        /**
                         * Generates commissions
                         */
                        $proposalValue = $loan->getProposal()->getValue();
                        $product = $loan->getProduct();
                        /**
                         * Company commissions
                         */
                        $fixedCommission = $product->getFixedCommission();
                        $variantCommission = $product->getVariantCommission();
                        $comm = (($proposalValue * $variantCommission) / 100) + $fixedCommission;
                        $commission = number_format($comm, 2);
                        $receivable = $this->getServiceLocator()->get('financial_create_receivable');
                        $receivable->setUser($loan->getProposal()->getUser());
                        $receivable->setCustomer($loan->getProposal()->getCustomer());
                        $receivable->setDescription("COM. REF. A CONSIGNADO Nº {$loan->getId()}");
                        $receivable->setValue($commission);
                        $receivable->create();

                        /**
                         * Employee Commissions
                         */
                        $companyCommission = $commission;
                        $employee = $loan->getProposal()->getEmployee();
                        if ($employee) {
                            $commissions = $employee->getCommissions();
                            if (count($commissions)) {
                                foreach ($commissions as $commission) {
                                    if ($commission->getProduct() === $product) {
                                        $empFixCom = $commission->getCommissionFixed();
                                        $empVarCom = $commission->getCommissionVariant();
                                        $empCommission = (($companyCommission * $empVarCom) / 100) + $empFixCom;
                                        $employeeCommission = number_format($empCommission, 2);
                                        $supplier = $employee->getSupplier();
                                        $payable = $this->getServiceLocator()->get('financial_create_payable');
                                        $payable->setUser($loan->getProposal()->getUser());
                                        $payable->setSupplier($supplier);
                                        $payable->setDescription("COM. REF. A CONSIGNADO Nº {$loan->getId()}.");
                                        $payable->setValue($employeeCommission);
                                        $payable->create();
                                    }
                                }
                            }
                        }
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
                            'bank' => $loan->getProposal()->getBank(),
                        );
                        break;
                }

                $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);

                $proposal = $loan->getProposal();
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
                            'baseDate' => $baseDate,
                            'startDate' => $startDate,
                            'endDate' => $endDate
                        );

                        $hydrator->hydrate($data, $proposal);
                    }
                }

                if ($post['proposalStatusId'] == 'APPROVED') {
                    $currencyFilter = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));
                    $proposalParcelAmount = $post['proposalStatusParcelAmount'];
                    $proposalParcelValue = $currencyFilter->filter($post['proposalStatusParcelValue']);
                    $proposalValue = $currencyFilter->filter($post['proposalStatusValue']);

                    if (!empty($proposalParcelAmount) && !empty($proposalParcelValue) && !empty($proposalValue)) {
                        $data = array(
                            'parcelAmount' => $proposalParcelAmount,
                            'parcelValue' => $proposalParcelValue,
                            'value' => $proposalValue,
                        );

                        $hydrator->hydrate($data, $proposal);
                    }
                }

                $log = new \DtlProposal\Entity\Log();
                $hydrator->hydrate($data_log, $log);
                $proposal->addLog($log);

                $em->persist($proposal);
                $em->persist($loan);
                $em->flush();

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

                $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);

                $post = $this->request->getPost()->bankReport;

                $bank = $em->find('DtlBank\Entity\Bank', $post['bank']);

                $dateFilter = new \DtlBase\Filter\Date();

                $baseDate = new \DateTime($dateFilter->filter($loan->getProposal()->getBaseDate()));

                $timestamp = $baseDate->getTimestamp();

                $endDate = $baseDate->setDate(date('Y', $timestamp), date('m', $timestamp) + $post['bankReportParcelAmount'] + 1, date('d', $timestamp));

                $dataProposal = array(
                    'bank' => $bank,
                    'parcelAmount' => $post['bankReportParcelAmount'],
                    'parcelValue' => $post['bankReportParcelValue'],
                    'lastExpiration' => date('Y-m-d', $endDate->getTimestamp()),
                    'isChecking' => true,
                    'isApproved' => false,
                    'isCanceled' => false,
                    'isIntegrated' => false,
                    'isRefused' => false,
                    'isAborted' => false,
                    'lastChange' => date('Y-m-d H:i:s'),
                );

                $proposal = $loan->getProposal();
                $hydrator->hydrate($dataProposal, $proposal);

                $dataLog = array(
                    'bank' => $bank,
                    'timestamp' => date('Y-m-d H:i:s'),
                    'message' => 'ABERTA: PROPOSTA SENDO ANALISADA PELO BANCO.'
                );
                $log = new \DtlProposal\Entity\Log();
                $hydrator->hydrate($dataLog, $log);
                $em->persist($log);
                $proposal->addLog($log);


                $activeBankReport = $loan->getProposal()->getBankReport();
                if (count($activeBankReport) > 0) {
                    foreach ($activeBankReport as $bankReportData) {
                        $bankReportData->setIsActive(false);
                        $em->persist($bankReportData);
                    }
                }

                $dataBankReport = array(
                    'bank' => $bank,
                    'isActive' => true
                );
                $bankReport = new \DtlProposal\Entity\BankReport();
                $hydrator->hydrate($dataBankReport, $bankReport);
                $proposal->addBankReport($bankReport);

                $em->persist($proposal);
                $em->persist($loan);

                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Migração bancária efetuada com sucesso na proposta nº ' . $loan->getId() . ' com sucesso!');
                return $this->redirect()->toRoute("admin/proposal/loan");
            }
        }

        return array(
            'form' => $form,
            'loan' => $loan,
        );
    }

    public function calculateAction() {

        $params = $this->params()->fromQuery();

        $currencyFilter = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));

        $totalValue = $currencyFilter->filter($params['totalValue']);
        $parcelAmount = $params['parcelAmount'];
        $proposalValue = $currencyFilter->filter($params['value']);

        $inValue = $totalValue - $proposalValue;

        $parcelValue = $proposalValue / $parcelAmount;

        $date = new \DateTime('now');
        $timestamp = $date->getTimestamp();
        $newDate = $date->setDate(date('Y', $timestamp), date('m', $timestamp) + ($parcelAmount + 1), date('d', $timestamp));
        $endDate = date('d/m/Y', $newDate->getTimestamp());

        $sDate = new \DateTime('now');
        $sTamp = $sDate->getTimestamp();
        $nDate = $sDate->setDate(date('Y', $sTamp), date('m', $sTamp) + 1, date('d', $sTamp));
        $startDate = date('d/m/Y', $nDate->getTimestamp());

        $result = array(
            'parcelValue' => $this->convertToCurrency($parcelValue),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'inValue' => $this->convertToCurrency($inValue)
        );

        return $this->response->setContent(\Zend\Json\Json::encode($result));
    }

    private function populate($customer) {

        /**
         * Populate Customer Bank Accounts
         */
        $customerBankAccounts = $customer->getAccounts();
        if (count($customerBankAccounts) > 0) {
            $customerBankAccount = array();
            foreach ($customerBankAccounts->toArray() as $bankAccount) {
                $customerBankAccount['bankAccountId'] = $bankAccount->getId();
                $customerBankAccount['bankAccountType'] = $bankAccount->getType();
                $customerBankAccount['bankAccountBank'] = $bankAccount->getBank();
                $customerBankAccount['bankAccountAgency'] = $bankAccount->getAgency();
                $customerBankAccount['bankAccountAccount'] = $bankAccount->getAccount();
                $customerBankAccount['bankAccountSince'] = $bankAccount->getSince();
                $this->getProposalSession()->customerBankAccounts[] = $customerBankAccount;
            }
        }

        /**
         * Populate Customer References
         */
        $customerRefereces = $customer->getReferences();
        if (count($customerRefereces) > 0) {
            $customerReference = array();
            foreach ($customerRefereces as $reference) {
                $customerReference['referenceId'] = $reference->getId();
                $customerReference['referenceType'] = $reference->getType();
                $customerReference['referenceName'] = $reference->getName();
                $customerReference['referencePhone'] = $reference->getPhone();
                $this->getProposalSession()->customerReferences[] = $customerReference;
            }
        }

        /**
         * Populate Customer Patrimony
         */
        $customerPatrimonies = $customer->getPatrimonies();
        if (count($customerPatrimonies) > 0) {
            $customerPatriomny = array();
            foreach ($customerPatrimonies as $patrimony) {
                $customerPatriomny['patrimonyId'] = $patrimony->getId();
                $customerPatriomny['patrimonyName'] = $patrimony->getName();
                $customerPatriomny['patrimonyValue'] = $patrimony->getValue();
                $this->getProposalSession()->customerPatrimonies[] = $customerPatriomny;
            }
        }

        $customerVehicles = $customer->getVehicles();
        if (count($customerVehicles) > 0) {
            $customerVehicle = array();
            foreach ($customerVehicles as $vehicle) {
                $customerVehicle['vehicleId'] = $vehicle->getId();
                $customerVehicle['vehicleBrandId'] = $vehicle->getBrand()->getId();
                $customerVehicle['vehicleBrandName'] = $vehicle->getBrand()->getName();
                $customerVehicle['vehicleTypeId'] = $vehicle->getType()->getId();
                $customerVehicle['vehicleTypeName'] = $vehicle->getType()->getName();
                $customerVehicle['vehicleModelId'] = $vehicle->getModel()->getId();
                $customerVehicle['vehicleModelName'] = $vehicle->getModel()->getName();
                $customerVehicle['vehicleVersionId'] = $vehicle->getVersion()->getId();
                $customerVehicle['vehicleVersionName'] = $vehicle->getVersion()->getName();
                $customerVehicle['vehicleYear'] = $vehicle->getYear();
                $customerVehicle['vehicleYearModel'] = $vehicle->getYearModel();
                $customerVehicle['vehiclePlate'] = $vehicle->getPlate();
                $customerVehicle['vehicleColor'] = $vehicle->getColor();
                $customerVehicle['vehicleValue'] = $vehicle->getValue();
                $this->getProposalSession()->customerVehicles[] = $customerVehicle;
            }
        }
    }

    public function listvehiclesAction() {
        $vehicles = array();
        if (!empty($this->getProposalSession()->vehicles)) {
            $vehicles = $this->getProposalSession()->vehicles;
        }
        $view = new ViewModel(array(
            'vehicles' => $vehicles,
        ));
        $view->setTemplate('proposal/loan/vehicle/listvehicles');
        return $view;
    }

    public function addvehicleAction() {
        if (!$this->getProposalSession()->vehicles) {
            $this->getProposalSession()->vehicles = array();
        }
        $vehicle = $this->params()->fromQuery();
        if (empty($vehicle['vehicleBrandId']) ||
                empty($vehicle['vehicleTypeId']) ||
                empty($vehicle['vehicleModelId']) ||
                empty($vehicle['vehicleVersionId'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        } else {
            $em = $this->getEntityManager();
            $currency = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));
            $vehicleBrand = $em->find('DtlVehicle\Entity\VehicleBrand', $vehicle['vehicleBrandId']);
            $vehicleType = $em->find('DtlVehicle\Entity\VehicleType', $vehicle['vehicleTypeId']);
            $vehicleModel = $em->find('DtlVehicle\Entity\VehicleModel', $vehicle['vehicleModelId']);
            $vehicleVersion = $em->find('DtlVehicle\Entity\VehicleVersion', $vehicle['vehicleVersionId']);
            $vehicle['vehicleBrandName'] = $vehicleBrand->getName();
            $vehicle['vehicleTypeName'] = $vehicleType->getName();
            $vehicle['vehicleModelName'] = $vehicleModel->getName();
            $vehicle['vehicleVersionName'] = $vehicleVersion->getName();
            $vehicle['vehicleValue'] = $currency->filter($vehicle['vehicleValue']);
            $this->getProposalSession()->vehicles[] = $vehicle;
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

    public function deletevehicleAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $vehicles = $this->getProposalSession()->vehicles;
        if ($item >= 0) {
            unset($vehicles[$item]);
            $this->getProposalSession()->vehicles = $vehicles;
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
    }

    public function listcustomerbankaccountAction() {
        $customerBankAccounts = array();
        if (!empty($this->getProposalSession()->customerBankAccounts)) {
            $customerBankAccounts = $this->getProposalSession()->customerBankAccounts;
        }
        $view = new ViewModel(array(
            'customerBankAccounts' => $customerBankAccounts,
        ));
        $view->setTemplate('dtl-proposal/proposal/customerbankaccountlist');
        return $view;
    }

    public function addcustomerbankaccountAction() {
        if (!$this->getProposalSession()->customerBankAccounts) {
            $this->getProposalSession()->customerBankAccounts = array();
        }
        $customerBankAccount = $this->params()->fromQuery();
        if (empty($customerBankAccount['bankAccountBank']) ||
                empty($customerBankAccount['bankAccountAgency']) ||
                empty($customerBankAccount['bankAccountAccount'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        } else {
            $this->getProposalSession()->customerBankAccounts[] = $customerBankAccount;
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

    public function deletecustomerbankaccountAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $dataId = (int) $this->params()->fromQuery('dataId');
        $customerBankAccounts = $this->getProposalSession()->customerBankAccounts;
        if ($item >= 0) {
            unset($customerBankAccounts[$item]);
            $this->getProposalSession()->customerBankAccounts = $customerBankAccounts;
            if (!empty($dataId)) {
                $em = $this->getEntityManager();
                $em->remove($em->find('DtlBankAccount\Entity\BankAccount', $dataId));
                $em->flush();
            }
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
    }

    public function listcustomerreferenceAction() {
        $customerReferences = array();
        if (!empty($this->getProposalSession()->customerReferences)) {
            $customerReferences = $this->getProposalSession()->customerReferences;
        }
        $view = new ViewModel(array(
            'customerReferences' => $customerReferences,
        ));
        $view->setTemplate('dtl-proposal/proposal/customerreferencelist');
        return $view;
    }

    public function addcustomerreferenceAction() {
        if (!$this->getProposalSession()->customerReferences) {
            $this->getProposalSession()->customerReferences = array();
        }
        $customerReference = $this->params()->fromQuery();
        if (empty($customerReference['referenceName']) ||
                empty($customerReference['referencePhone'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        } else {
            $filter = new \Zend\Filter\Digits();
            $customerReference['referencePhone'] = $filter->filter($customerReference['referencePhone']);
            $this->getProposalSession()->customerReferences[] = $customerReference;
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

    public function deletecustomerreferenceAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $dataId = (int) $this->params()->fromQuery('dataId');
        $customerReferences = $this->getProposalSession()->customerReferences;
        if ($item >= 0) {
            unset($customerReferences[$item]);
            $this->getProposalSession()->customerReferences = $customerReferences;
            if (!empty($dataId)) {
                $em = $this->getEntityManager();
                $em->remove($em->find('DtlReference\Entity\Reference', $dataId));
                $em->flush();
            }
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
    }

    public function listcustomerpatrimonyAction() {
        $customerPatrimonies = array();
        if (!empty($this->getProposalSession()->customerPatrimonies)) {
            $customerPatrimonies = $this->getProposalSession()->customerPatrimonies;
        }
        $view = new ViewModel(array(
            'customerPatrimonies' => $customerPatrimonies,
        ));
        $view->setTemplate('dtl-proposal/proposal/customerpatrimonylist');
        return $view;
    }

    public function addcustomerpatrimonyAction() {
        if (!$this->getProposalSession()->customerPatrimonies) {
            $this->getProposalSession()->customerPatrimonies = array();
        }
        $customerPatrimony = $this->params()->fromQuery();
        if (empty($customerPatrimony['patrimonyName']) ||
                empty($customerPatrimony['patrimonyValue'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        } else {
            $filter = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));
            $customerPatrimony['patrimonyValue'] = $filter->filter($customerPatrimony['patrimonyValue']);
            $this->getProposalSession()->customerPatrimonies[] = $customerPatrimony;
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

    public function deletecustomerpatrimonyAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $dataId = (int) $this->params()->fromQuery('dataId');
        $customerPatrimonies = $this->getProposalSession()->customerPatrimonies;
        if ($item >= 0) {
            unset($customerPatrimonies[$item]);
            $this->getProposalSession()->customerPatrimonies = $customerPatrimonies;
            if (!empty($dataId)) {
                $em = $this->getEntityManager();
                $em->remove($em->find('DtlPatrimony\Entity\Patrimony', $dataId));
                $em->flush();
            }
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
    }

    public function listcustomervehicleAction() {
        $customerVehicle = array();
        if (!empty($this->getProposalSession()->customerVehicles)) {
            $customerVehicle = $this->getProposalSession()->customerVehicles;
        }
        $view = new ViewModel(array(
            'customerVehicles' => $customerVehicle,
        ));
        $view->setTemplate('dtl-proposal/proposal/customervehiclelist');
        return $view;
    }

    public function addcustomervehicleAction() {
        if (!$this->getProposalSession()->customerVehicles) {
            $this->getProposalSession()->customerVehicles = array();
        }
        $customerVehicle = $this->params()->fromQuery();
        if (empty($customerVehicle['vehicleBrandId']) ||
                empty($customerVehicle['vehicleTypeId']) ||
                empty($customerVehicle['vehicleModelId']) ||
                empty($customerVehicle['vehicleVersionId'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        } else {
            $em = $this->getEntityManager();
            $currency = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));
            $vehicleBrand = $em->find('DtlVehicle\Entity\VehicleBrand', $customerVehicle['vehicleBrandId']);
            $vehicleType = $em->find('DtlVehicle\Entity\VehicleType', $customerVehicle['vehicleTypeId']);
            $vehicleModel = $em->find('DtlVehicle\Entity\VehicleModel', $customerVehicle['vehicleModelId']);
            $vehicleVersion = $em->find('DtlVehicle\Entity\VehicleVersion', $customerVehicle['vehicleVersionId']);
            $customerVehicle['vehicleBrandName'] = $vehicleBrand->getName();
            $customerVehicle['vehicleTypeName'] = $vehicleType->getName();
            $customerVehicle['vehicleModelName'] = $vehicleModel->getName();
            $customerVehicle['vehicleVersionName'] = $vehicleVersion->getName();
            $customerVehicle['vehicleValue'] = $currency->filter($customerVehicle['vehicleValue']);
            $this->getProposalSession()->customerVehicles[] = $customerVehicle;
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

    public function deletecustomervehicleAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $dataId = (int) $this->params()->fromQuery('dataId');
        $customerVehicles = $this->getProposalSession()->customerVehicles;
        if ($item >= 0) {
            unset($customerVehicles[$item]);
            $this->getProposalSession()->customerVehicles = $customerVehicles;
            if (!empty($dataId)) {
                $em = $this->getEntityManager();
                $em->remove($em->find('DtlVehicle\Entity\Vehicle', $dataId));
                $em->flush();
            }
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

    public function exportPdfAction() {
        $query = $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->createQueryBuilder('l')
                ->select('l.loanId, pe.name, p.date, p.value, p.parcelAmount, p.parcelValue, b.name')
                ->join('l.proposal', 'p')
                ->join('p.customer', 'c')
                ->join('p.bank', 'b')
                ->join('c.person', 'pe')
                ->where('p.isActive = TRUE')
                ->orderBy('p.timestamp', 'DESC');

        $header = array('ID', 'NOME', 'DATA', 'VALOR FIN.', 'PARCELAS', 'VAL. PARCELA', 'BANCO');

        return $this->csvExport('foo.csv', $header, $query->getQuery()->getArrayResult());
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
