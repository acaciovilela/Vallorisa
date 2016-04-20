<?php

namespace DtlProposal\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use DtlProposal\Form\RealtyProposal as RealtyProposalForm;
use Zend\Json\Json;

class RealtyProposalController extends AbstractActionController {

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
                ->createQueryBuilder('rp')
                ->join('rp.proposal', 'p')
                ->where('p.isActive = TRUE')
                ->orderBy('p.timestamp', 'DESC');

        if ($this->getRequest()->isPost()) {
            $query = $this->searchQuery->realtyProposalSearch($query, $this->getRequest()->getPost());
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
            'realtyProposal' => $paginator
        );
    }

    public function preAction() {
        $this->getProposalService()->resetSession();
        $form = new \DtlProposal\Form\PreProposal();
        $form->get('cancel')->setAttribute('onclick', "javascript: window.location.href = '/admin/proposal/realty-proposal';");
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->getProposalSession()->prePost = $this->request->getPost();
                $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal/add');
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
        $form = new RealtyProposalForm($this->getEntityManager(), $userId);
        $realtyProposal = new \DtlProposal\Entity\RealtyProposal();
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
            $realtyProposal->getProposal()->setCustomer($result);
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($result);
        }
        $form->bind($realtyProposal);
        $form->get('realtyProposal')
                ->get('proposal')
                ->get('customer')
                ->get('person')->setValue($personType);
        if ((int)$personType) {
            $form->get('realtyProposal')
                    ->get('proposal')
                    ->get('customer')
                    ->get('person')
                    ->get('legal')
                    ->get('cnpj')
                    ->setValue($personDocument);
        } else {
            $form->get('realtyProposal')
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

                $customer = $realtyProposal->getProposal()->getCustomer();

                $customer->setCompanyId($userId);

                $this->getProposalService()->addCustomerBankAccount($customer);

                $this->getProposalService()->addCustomerReference($customer);

                $realtyProposal->getProposal()->setCustomer($customer);
                /**
                 * Resume routines
                 */
                $bank = $em->find('DtlBank\Entity\Bank', $post->realtyProposal['proposal']['bank']);
                $bankReport = new \DtlProposal\Entity\BankReport();
                $bankReport->setIsActive(true);
                $bankReport->setBank($bank);
                $em->persist($bankReport);

                $realtyProposal->getProposal()->addBankReport($bankReport);
                $log = new \DtlProposal\Entity\Log();
                $log->setBank($bank);
                $log->setMessage('ABERTA: PROPOSTA EM ANÁLISE');
                $em->persist($log);

                $realtyProposal->getProposal()->addLog($log);
                $em->persist($realtyProposal);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Proposta cadastrada com sucesso!');

                return $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal');
            }
        }
        return array(
            'form' => $form,
            'post' => $this->getProposalSession()->prePost,
            'entityManager' => $this->getEntityManager(),
            'userId' => $this->identity()->getId(),
        );
    }

    public function editAction() {

        $proposalId = $this->params()->fromRoute('id');

        $userId = $this->identity()->getId();

        $form = new RealtyProposalForm($this->getEntityManager(), $userId);

        $em = $this->getEntityManager();

        $realtyProposal = $em->find($this->getRepository(), $proposalId);

        if (!$this->request->isPost()) {
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($realtyProposal->getProposal()->getCustomer());
        }

        $form->bind($realtyProposal);

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $customer = $realtyProposal->getProposal()->getCustomer();
                $this->getProposalService()->addCustomerBankAccount($customer);
                $this->getProposalService()->addCustomerReference($customer);
                $em->persist($customer);

                $bank = $em->find('DtlBank\Entity\Bank', $post->realtyProposal['proposal']['bank']);
                $log = new \DtlProposal\Entity\Log();
                $log->setBank($bank);
                $log->setMessage('ATUALIZAÇÃO: PROPOSATA ATUALIZADA!');
                $em->persist($log);

                $realtyProposal->getProposal()->addLog($log);
                $em->persist($realtyProposal);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Proposta cadastrada com sucesso!');

                return $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal');
            }
        }

        return array(
            'form' => $form,
            'realtyProposal' => $realtyProposal,
            'entityManager' => $this->getEntityManager(),
            'companyId' => $userId,
        );
    }

    public function deleteAction() {
        $realtyProposalId = $this->params()->fromRoute('id');
        if (!$realtyProposalId) {
            return $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal');
        }
        $em = $this->getEntityManager();
        $realtyProposal = $em->find($this->getRepository(), $realtyProposalId);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $em->remove($realtyProposal);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Proposta apagada com sucesso!');
            } else {
                $this->flashMessenger()->addInfoMessage('Nenhuma alteração foi gravada!');
            }
            return $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal');
        }
        return array(
            'id' => $realtyProposalId,
            'customer' => $realtyProposal->getProposal()->getCustomer()
        );
    }

    public function viewAction() {

        $realtyProposalId = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();

        $realtyProposal = $em->find('DtlProposal\Entity\RealtyProposal', $realtyProposalId);

        return array(
            'realtyProposal' => $realtyProposal,
        );
    }

    public function historyAction() {
        $realtyProposalId = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();

        $realtyProposal = $em->find('DtlProposal\Entity\RealtyProposal', $realtyProposalId);

        return array(
            'realtyProposal' => $realtyProposal,
        );
    }

    public function statusAction() {

        $realtyProposalId = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();

        $realtyProposal = $em->find('DtlProposal\Entity\RealtyProposal', $realtyProposalId);

        if ($realtyProposal->getProposal()->getIsRefused()) {
            return array(
                'refused' => true,
                'realtyProposal' => $realtyProposal,
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
                            'bank' => $realtyProposal->getProposal()->getBank(),
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
                            'bank' => $realtyProposal->getProposal()->getBank(),
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
                            'bank' => $realtyProposal->getProposal()->getBank(),
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
                            'bank' => $realtyProposal->getProposal()->getBank(),
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
                            'bank' => $realtyProposal->getProposal()->getBank(),
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
                            'bank' => $realtyProposal->getProposal()->getBank(),
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
                            'bank' => $realtyProposal->getProposal()->getBank(),
                        );

                        /**
                         * Generates commissions
                         */
                        $proposalValue = $realtyProposal->getProposal()->getValue();
                        $product = $realtyProposal->getProduct();
                        /**
                         * Company commissions
                         */
                        $fixedCommission = $product->getFixedCommission();
                        $variantCommission = $product->getVariantCommission();
                        $commission = (($proposalValue * $variantCommission) / 100) + $fixedCommission;
                        $commission = number_format($commission, 2);
                        $receivable = $this->getServiceLocator()->get('financial_create_receivable');
                        $receivable->setCompany($realtyProposal->getProposal()->getCompany());
                        $receivable->setCustomer($realtyProposal->getProposal()->getCustomer());
                        $receivable->setDescription("COM. REF. A PROPOSTA DE IMÓVEL Nº {$realtyProposal->getId()}");
                        $receivable->setValue($commission);
                        $receivable->create();

                        /**
                         * Employee Commissions
                         */
                        $companyCommission = $commission;
                        $employee = $realtyProposal->getProposal()->getEmployee();
                        if ($employee) {
                            $commissions = $employee->getCommissions();
                            if (count($commissions)) {
                                foreach ($commissions as $commission) {
                                    if ($commission->getProduct() === $product) {
                                        $empFixCom = $commission->getEmployeeCommissionFixed();
                                        $empVarCom = $commission->getEmployeeCommissionVariant();
                                        $empCommission = (($companyCommission * $empVarCom) / 100) + $empFixCom;
                                        $employeeCommission = number_format($empCommission, 2);
                                        $supplier = $employee->getSupplier();
                                        $payable = $this->getServiceLocator()->get('financial_create_payable');
                                        $payable->setCompany($realtyProposal->getProposal()->getCompany());
                                        $payable->setSupplier($supplier);
                                        $payable->setDescription("COM. REF. A PROPOSTA DE IMÓVEL Nº {$realtyProposal->getId()}.");
                                        $payable->setValue($employeeCommission);
                                        $payable->create();
                                    }
                                }
                            }
                        }

                        /**
                         * Realtor Commissions
                         */
                        $realtor = $realtyProposal->getRealtor();
                        if ($realtor) {
                            $rltVarCom = $realtor->getCommission();
                            $rltFixCom = $realtor->getFixedCommission();
                            $bonus = $realtor->getBonus();
                            $relatorCommission = ((($companyCommission * $rltVarCom) / 100) + $rltFixCom) + $bonus;
                            $realtorCommission = number_format($relatorCommission, 2);
                            $supplier = $realtor->getSupplier();
                            $payable = $this->getServiceLocator()->get('financial_create_payable');
                            $payable->setCompany($realtyProposal->getProposal()->getCompany());
                            $payable->setSupplier($supplier);
                            $payable->setDescription("COM. DE CORRETOR REF. A PROPOSTA DE IMÓVEL Nº {$realtyProposal->getId()}.");
                            $payable->setValue($realtorCommission);
                            $payable->create();
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
                            'bank' => $realtyProposal->getProposal()->getBank(),
                        );
                        break;
                }

                $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);

                $proposal = $realtyProposal->getProposal();
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
                    $realtyProposalTotalValue = $realtyProposal->getTotalValue();
                    $proposalParcelAmount = $post['proposalStatusParcelAmount'];
                    $proposalParcelValue = $currencyFilter->filter($post['proposalStatusParcelValue']);
                    $proposalValue = $currencyFilter->filter($post['proposalStatusValue']);
                    $realtyProposalInValue = $realtyProposalTotalValue - $proposal->getValue();

                    if (!empty($proposalParcelAmount) && !empty($proposalParcelValue) && !empty($proposalValue)) {
                        $data = array(
                            'proposalParcelAmount' => $proposalParcelAmount,
                            'proposalParcelValue' => $proposalParcelValue,
                            'proposalValue' => $proposalValue,
                        );

                        $hydrator->hydrate($data, $proposal);
                        $realtyProposal->setRealtyProposalInValue($realtyProposalInValue);
                    }
                }

                $log = new \DtlProposal\Entity\Log();
                $hydrator->hydrate($data_log, $log);
                $proposal->addLog($log);

                $em->persist($proposal);
                $em->persist($realtyProposal);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Status da proposta alterado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal');
            }
        }

        return array(
            'form' => $form,
            'realtyProposal' => $realtyProposal,
        );
    }

    public function bankAction() {
        $realtyProposalId = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();

        $realtyProposal = $em->find('DtlProposal\Entity\RealtyProposal', $realtyProposalId);

        if ($realtyProposal->getProposal()->getIsChecking()) {
            return array(
                'checking' => true,
                'realtyProposal' => $realtyProposal,
            );
        }

        $form = new \DtlProposal\Form\BankReport($em);
        $form->get('bankReport')->get('bankReportParcelAmount')->setValue($realtyProposal->getProposal()->getParcelAmount());
        $form->get('bankReport')->get('bankReportParcelValue')->setValue($vehicleProposal->getProposal()->getParcelValue());

        if ($this->request->isPost()) {

            $form->setData($this->request->getPost());

            if ($form->isValid()) {

                $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);

                $post = $this->request->getPost()->bankReport;

                $bank = $em->find('DtlBank\Entity\Bank', $post['bank']);

                $dateFilter = new \DtlBase\Filter\Date();

                $baseDate = new \DateTime($dateFilter->filter($realtyProposal->getProposal()->getBaseDate()));

                $timestamp = $baseDate->getTimestamp();

                $endDate = $baseDate->setDate(date('Y', $timestamp), date('m', $timestamp) + $post['bankReportParcelAmount'] + 1, date('d', $timestamp));

                $dataProposal = array(
                    'bank' => $bank,
                    'proposalParcelAmount' => $post['bankReportParcelAmount'],
                    'proposalParcelValue' => $post['bankReportParcelValue'],
                    'proposalLastExpiration' => date('Y-m-d', $endDate->getTimestamp()),
                    'isChecking' => true,
                    'isApproved' => false,
                    'isCanceled' => false,
                    'isIntegrated' => false,
                    'isRefused' => false,
                    'isAborted' => false,
                    'lastChange' => date('Y-m-d H:i:s'),
                );

                $proposal = $realtyProposal->getProposal();
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


                $activeBankReport = $realtyProposal->getProposal()->getBankReport();
                if (count($activeBankReport) > 0) {
                    foreach ($activeBankReport as $bankReportData) {
                        $bankReportData->setIsActive(false);
                        $em->persist($bankReportData);
                    }
                }

                $dataBankReport = array(
                    'bank' => $bank,
                    'bankReportIsActive' => true
                );
                $bankReport = new \DtlProposal\Entity\BankReport();
                $hydrator->hydrate($dataBankReport, $bankReport);
                $proposal->addBankReport($bankReport);

                $em->persist($proposal);
                $em->persist($realtyProposal);

                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Migração bancária efetuada com sucesso!');
                return $this->redirect()->toRoute("admin/proposal/realty-proposal");
            }
        }

        return array(
            'form' => $form,
            'realtyProposal' => $realtyProposal,
        );
    }

    public function evaluationAction() {

        $realtyProposalId = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();

        $realtyProposal = $em->find('DtlProposal\Entity\RealtyProposal', $realtyProposalId);

        $form = new \DtlProposal\Form\RealtyEvaluation($em);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);
                $post = $this->request->getPost()->realtyEvaluation;
                $bank = $em->find('DtlBank\Entity\Bank', $post['bank']);

                $dataLog = array(
                    'bank' => $bank,
                    'timestamp' => date('Y-m-d H:i:s'),
                    'message' => 'AVALIAÇÃO: O IMÓVEL ESTÁ SENDO AVALIADO PELO ENGENHEIRO.',
                );

                $proposal = $realtyProposal->getProposal();
                $log = new \DtlProposal\Entity\Log();
                $hydrator->hydrate($dataLog, $log);
                $em->persist($log);
                $proposal->addLog($log);

                $activeBankReport = $realtyProposal->getProposal()->getBankReport();
                if (count($activeBankReport) > 0) {
                    foreach ($activeBankReport as $bankReportData) {
                        $bankReportData->setIsActive(false);
                        $em->persist($bankReportData);
                    }
                }

                $dataBankReport = array(
                    'bank' => $bank,
                    'bankReportIsActive' => true
                );
                $bankReport = new \DtlProposal\Entity\BankReport();
                $hydrator->hydrate($dataBankReport, $bankReport);
                $proposal->addBankReport($bankReport);

                $em->persist($proposal);

                $realtyProposal->addEvaluations($form->getData());
//                $realtyProposal->setRealtyProposalTotalValue($form->getData()->getRealtyEvaluationValue());
//                $realtyProposal->getRealty()->setRealtyValue($form->getData()->getRealtyEvaluationValue());
                $inValue = $realtyProposal->getTotalValue() - $realtyProposal->getProposal()->getValue();
                $realtyProposal->setRealtyProposalInValue($inValue);

                $em->persist($realtyProposal);

                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Avaliação do imóvel efetuada com sucesso!');
                return $this->redirect()->toRoute("admin/proposal/realty-proposal");
            }
        }

        return array(
            'form' => $form,
            'realtyProposal' => $realtyProposal,
        );
    }

    public function evaluationEditAction() {
        $realtyProposalId = $this->params()->fromRoute('id');
        $evalId = $this->params()->fromRoute('evalId');
        $em = $this->getEntityManager();
        $realtyProposal = $em->find('DtlProposal\Entity\RealtyProposal', $realtyProposalId);
        $form = new \DtlProposal\Form\RealtyEvaluation($em);
        $evaluation = $em->find('\DtlProposal\Entity\RealtyEvaluation', $evalId);
        $form->bind($evaluation);
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);
                $post = $this->request->getPost()->realtyEvaluation;
                $bank = $em->find('DtlBank\Entity\Bank', $post['bank']);

                $dataLog = array(
                    'bank' => $bank,
                    'timestamp' => date('Y-m-d H:i:s'),
                    'message' => 'AVALIAÇÃO: O IMÓVEL ESTÁ SENDO AVALIADO PELO ENGENHEIRO.',
                );

                $proposal = $realtyProposal->getProposal();
                $log = new \DtlProposal\Entity\Log();
                $hydrator->hydrate($dataLog, $log);
                $em->persist($log);
                $proposal->addLog($log);

                $activeBankReport = $realtyProposal->getProposal()->getBankReport();
                if (count($activeBankReport) > 0) {
                    foreach ($activeBankReport as $bankReportData) {
                        $bankReportData->setIsActive(false);
                        $em->persist($bankReportData);
                    }
                }

                $dataBankReport = array(
                    'bank' => $bank,
                    'bankReportIsActive' => true
                );
                $bankReport = new \DtlProposal\Entity\BankReport();
                $hydrator->hydrate($dataBankReport, $bankReport);
                $proposal->addBankReport($bankReport);

                $em->persist($proposal);
                $em->persist($evaluation);

//                $realtyProposal->addEvaluations($form->getData());
                $inValue = $realtyProposal->getTotalValue() - $realtyProposal->getProposal()->getValue();
                $realtyProposal->setRealtyProposalInValue($inValue);

                $em->persist($realtyProposal);

                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Avaliação do imóvel atualizada com sucesso!');
                return $this->redirect()->toRoute("admin/proposal/realty-proposal");
            }
        }

        return array(
            'form' => $form,
            'evalId' => $evalId,
            'realtyProposal' => $realtyProposal,
        );
    }

    public function searchAction() {
        $form = new \DtlProposal\Form\Search($this->getEntityManager(), $this->identity()->getId());
        return new \Zend\View\Model\ViewModel(array(
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
                ->select('rp.realtyProposalId, p.name, p.type, l.cnpj, '
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
                $proposal['realtyProposalId'],
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

        return $this->csvExport('propostas_imoveis_' . date('dmYHis'), $header, $data, null, ';');
    }

    public function calculateAction() {
        $filter = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));

        $inValue = $this->params()->fromPost('inValue');
        $totalValue = $this->params()->fromPost('totalValue');

        $value = number_format($filter->filter($totalValue) - $filter->filter($inValue), 2, ',', '.');

        return $this->response->setContent(Json::encode(array('value' => $value)));
    }

    public function uploadAction() {
        $id = $this->params()->fromPost('proposalId');
        $ds = '/';
        $storeFolder = 'D:/server/www/vallorisa/public/uploads';
        $form = new \DtlFile\Form\File($this->getEntityManager());
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
            $form->setData($post);
            if ($form->isValid()) {
                $files = $this->getRequest()->getFiles()->toArray();
                foreach ($files as $file) {
                    $extension = substr($file['name'], strrpos($file['name'], '.'), 4);
                    $filename = md5(date('Y-m-d H:i:s')) . $extension;
                    $tempFile = $file['tmp_name'];
                    $targetPath = $storeFolder . $ds;
                    $targetFile = $targetPath . $filename;
                    
                    move_uploaded_file($tempFile, $targetFile);

                    $em = $this->getEntityManager();
                    $newfile = new \DtlFile\Entity\File();
                    $newfile->setName($filename)
                            ->setIsActive(true)
                            ->setSize($file['size'])
                            ->setType($file['type'])
                            ->setUrl($targetFile)
                            ->setTitle($filename)
                            ->setDescription('');
                    $em->persist($newfile);
                    $proposal = $em->find('DtlProposal\Entity\Proposal', $id);
                    $proposal->addFile($newfile);
                    $em->flush();
                }
            }
        }
        return $this->response->setContent(Json::encode(array('status' => 'ok')));
    }

    public function deleteFileAction() {
        $em = $this->getEntityManager();
        $id = $this->params()->fromRoute('id', 0);
        $file = $em->find('DtlFile\Entity\File', $id);
        $proposalId = $this->params()->fromRoute('proposalId');
        $realtyProposal = $em->getRepository($this->getRepository())->findOneBy(array('proposal' => $proposalId));
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                if (file_exists($file->getUrl())) {
                    unlink($file->getUrl());
                }
                $id = $request->getPost('id');
                $proposal = $em->find('DtlProposal\Entity\Proposal', $proposalId);
                $proposal->removeFile($file);
                $em->flush();
            }
            return $this->redirect()->toUrl('/dtladmin/dtlproposal/realty-proposal/1/view/' . $realtyProposal->getId());
        }
        return array(
            'fileId' => $id,
            'proposalId' => $proposalId,
            'file' => $file
        );
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
