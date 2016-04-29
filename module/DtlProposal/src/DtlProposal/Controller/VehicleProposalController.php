<?php

namespace DtlProposal\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use DtlProposal\Form\VehicleProposal as VehicleProposalForm;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;

class VehicleProposalController extends AbstractActionController {

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
    protected $response;

    public function indexAction() {

        $query = $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->createQueryBuilder('vp')
                ->join('vp.proposal', 'p')
                ->where('p.isActive = TRUE')
                ->orderBy('p.timestamp', 'DESC');

        if ($this->getRequest()->isPost()) {
            $query = $this->searchQuery->vehicleProposalSearch($query, $this->getRequest()->getPost());
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
            'vehicleProposal' => $paginator,
        );
    }

    public function preAction() {
        $this->getProposalService()->resetSession();
        $form = new \DtlProposal\Form\PreProposal();
        $form->get('cancel')->setAttribute('onclick', "javascript: window.location.href = '/admin/proposal/vehicle-proposal';");
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->getProposalSession()->prePost = $this->request->getPost();
                $this->redirect()->toRoute('dtladmin/dtlproposal/vehicle-proposal/add');
            } else {
                $form->get('preProposal')->get('personType')->setValue('');
            }
        }
        return array(
            'form' => $form
        );
    }

    public function addAction() {

        $userId = $this->dtlUserMasterIdentity()->getId();

        $form = new VehicleProposalForm($this->getEntityManager(), $userId);

        $vehicleProposal = new \DtlProposal\Entity\VehicleProposal();

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

            $vehicleProposal->getProposal()->setCustomer($result);

            $this->getProposalService()->resetSession();

            $this->getProposalService()->populate($result);
        }

        $form->bind($vehicleProposal);

        $form->get('vehicleProposal')
                ->get('proposal')
                ->get('customer')
                ->get('person')->setValue($personType);

        if ($personType) {
            $form->get('vehicleProposal')
                    ->get('proposal')
                    ->get('customer')
                    ->get('person')
                    ->get('legal')
                    ->get('cnpj')
                    ->setValue($personDocument);
        } else {
            $form->get('vehicleProposal')
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

                $doctrineHydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);

                /**
                 * Add Vehicles
                 */
                $vehicles = $sessionContainer->vehicles;
                if (count($vehicles) > 0) {
                    foreach ($vehicles as $vehicleData) {
                        $vehicle = new \DtlVehicle\Entity\Vehicle();
                        $doctrineHydrator->hydrate($vehicleData, $vehicle);
                        $vehicleProposal->addVehicle($vehicle);
                    }
                }

                $customer = $vehicleProposal->getProposal()->getCustomer();

                $customer->setUser($userId);

                $this->getProposalService()->addCustomerBankAccount($customer);

                $this->getProposalService()->addCustomerReference($customer);

                $this->getProposalService()->addCustomerPatrimony($customer);

                $this->getProposalService()->addCustomerVehicle($customer);

                $em->persist($customer);

                $vehicleProposal->getProposal()->setCustomer($customer);

                /**
                 * Resume routines
                 */
                $bank = $em->find('DtlBank\Entity\Bank', $post->vehicleProposal['proposal']['bank']);

                $bankReport = new \DtlProposal\Entity\BankReport();
                $bankReport->setIsActive(true);
                $bankReport->setBank($bank);
                $em->persist($bankReport);
                $vehicleProposal->getProposal()->addReport($bankReport);

                $log = new \DtlProposal\Entity\Log();
                $log->setBank($bank);
                $log->setMessage('ABERTA: PROPOSTA EM ANÁLISE');
                $em->persist($log);
                $vehicleProposal->getProposal()->addLog($log);

                $em->persist($vehicleProposal);

                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Proposta cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/vehicle-proposal');
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

        $form = new VehicleProposalForm($this->getEntityManager(), $userId);

        $em = $this->getEntityManager();

        $vehicleProposal = $em->find($this->getRepository(), $proposalId);

        if (!$this->request->isPost()) {
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($vehicleProposal->getProposal()->getCustomer());
            $this->getProposalService()->addProposalVehicles($vehicleProposal);
        }

        $form->bind($vehicleProposal);

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $sessionContainer = $this->getProposalSession();
                $doctrineHydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);

                /**
                 * Add Vehicles
                 */
                $vehicles = $sessionContainer->vehicles;
                if (count($vehicles) > 0) {
                    foreach ($vehicles as $vehicleData) {
                        if (!$vehicleData['vehicleId']) {
                            $vehicle = new \DtlVehicle\Entity\Vehicle();
                            $doctrineHydrator->hydrate($vehicleData, $vehicle);
                            $vehicleProposal->addVehicle($vehicle);
                        }
                    }
                }

                $customer = $vehicleProposal->getProposal()->getCustomer();
                $this->getProposalService()->addCustomerBankAccount($customer);
                $this->getProposalService()->addCustomerReference($customer);
                $this->getProposalService()->addCustomerPatrimony($customer);
                $this->getProposalService()->addCustomerVehicle($customer);
                $em->persist($customer);

                /**
                 * Resume routines
                 */
                $bank = $em->find('DtlBank\Entity\Bank', $post->vehicleProposal['proposal']['bank']);

                $log = new \DtlProposal\Entity\Log();
                $log->setBank($bank);
                $log->setMessage('ATUALIZAÇÃO: PROPOSTA ATUALIZADA!');
                $em->persist($log);
                $vehicleProposal->getProposal()->addLog($log);

                $em->persist($vehicleProposal);

                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Proposta atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/vehicle-proposal');
            }
        }

        return array(
            'form' => $form,
            'vehicleProposal' => $vehicleProposal,
            'entityManager' => $this->getEntityManager(),
            'companyId' => $userId,
        );
    }

    public function deleteAction() {
        $vehicleProposalId = $this->params()->fromRoute('id');
        if (!$vehicleProposalId) {
            return $this->redirect()->toRoute('dtladmin/dtlproposal/vehicle-proposal');
        }
        $em = $this->getEntityManager();
        $vehicleProposal = $em->find($this->getRepository(), $vehicleProposalId);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $em->remove($vehicleProposal);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Proposta apagada com sucesso!');
            } else {
                $this->flashMessenger()->addInfoMessage('Nenhuma alteração foi gravada!');
            }
            return $this->redirect()->toRoute('dtladmin/dtlproposal/vehicle-proposal');
        }
        return array(
            'id' => $vehicleProposalId,
            'customer' => $vehicleProposal->getProposal()->getCustomer()
        );
    }

    public function viewAction() {
        $vehicleProposalId = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();

        $vehicleProposal = $em->find('DtlProposal\Entity\VehicleProposal', $vehicleProposalId);

        return array(
            'vehicleProposal' => $vehicleProposal,
        );
    }

    public function historyAction() {
        $vehicleProposalId = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();

        $vehicleProposal = $em->find('DtlProposal\Entity\VehicleProposal', $vehicleProposalId);

        return array(
            'vehicleProposal' => $vehicleProposal,
        );
    }

    public function statusAction() {

        $vehicleProposalId = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();

        $vehicleProposal = $em->find('DtlProposal\Entity\VehicleProposal', $vehicleProposalId);

        if ($vehicleProposal->getProposal()->getIsRefused()) {
            return array(
                'refused' => true,
                'vehicleProposal' => $vehicleProposal,
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
                            'bank' => $vehicleProposal->getProposal()->getBank(),
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
                            'bank' => $vehicleProposal->getProposal()->getBank(),
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
                            'bank' => $vehicleProposal->getProposal()->getBank(),
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
                            'bank' => $vehicleProposal->getProposal()->getBank(),
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
                            'bank' => $vehicleProposal->getProposal()->getBank(),
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
                            'bank' => $vehicleProposal->getProposal()->getBank(),
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
                            'bank' => $vehicleProposal->getProposal()->getBank(),
                        );

                        /**
                         * Generates commissions
                         */
                        $proposalValue = $vehicleProposal->getProposal()->getValue();
                        $product = $vehicleProposal->getProduct();
                        /**
                         * Company commissions
                         */
                        $fixedCommission = $product->getFixedCommission();
                        $variantCommission = $product->getVariantCommission();
                        $commission = (($proposalValue * $variantCommission) / 100) + $fixedCommission;
                        $commission = number_format($commission, 2);
                        $receivable = $this->getServiceLocator()->get('dtlfinancial_create_receivable');
                        $receivable->setUser($vehicleProposal->getProposal()->getUser());
                        $receivable->setCustomer($vehicleProposal->getProposal()->getCustomer());
                        $receivable->setDescription("COM. REF. A PROPOSTA DE VEÍCULOS Nº {$vehicleProposal->getId()}");
                        $receivable->setValue($commission);
                        $receivable->create();

                        /**
                         * Employee Commissions
                         */
                        $companyCommission = $commission;
                        $employee = $vehicleProposal->getProposal()->getEmployee();
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
                                        $payable = $this->getServiceLocator()->get('dtlfinancial_create_payable');
                                        $payable->setUser($vehicleProposal->getProposal()->getUser());
                                        $payable->setSupplier($supplier);
                                        $payable->setDescription("COM. REF. A PROPOSTA DE VEÍCULOS Nº {$vehicleProposal->getId()}.");
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
                            'bank' => $vehicleProposal->getProposal()->getBank(),
                        );
                }

                $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);
                $proposal = $vehicleProposal->getProposal();
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
                    $vehicleProposalTotalValue = $vehicleProposal->getValue();
                    $proposalParcelAmount = $post['proposalStatusParcelAmount'];
                    $proposalParcelValue = $currencyFilter->filter($post['proposalStatusParcelValue']);
                    $proposalValue = $currencyFilter->filter($post['proposalStatusValue']);
                    $vehicleProposalInValue = $vehicleProposalTotalValue - $proposal->getValue();

                    if (!empty($proposalParcelAmount) && !empty($proposalParcelValue) && !empty($proposalValue)) {
                        $data_vp = array(
                            'parcelAmount' => $proposalParcelAmount,
                            'parcelValue' => $proposalParcelValue,
                            'value' => $proposalValue,
                        );

                        $hydrator->hydrate($data_vp, $proposal);
                    }
                }
                
                $log = new \DtlProposal\Entity\Log();
                $hydrator->hydrate($data_log, $log);
                $proposal->addLog($log);

                $em->persist($proposal);
                $em->persist($vehicleProposal);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Status da proposta alterado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/vehicle-proposal');
            }
        }

        return array(
            'form' => $form,
            'vehicleProposal' => $vehicleProposal,
        );
    }

    public function bankAction() {
        $vehicleProposalId = $this->params()->fromRoute('id');

        $em = $this->getEntityManager();

        $vehicleProposal = $em->find('DtlProposal\Entity\VehicleProposal', $vehicleProposalId);

        if ($vehicleProposal->getProposal()->getIsChecking()) {
            return array(
                'checking' => true,
                'vehicleProposal' => $vehicleProposal,
            );
        }

        $form = new \DtlProposal\Form\BankReport($em);
        $form->get('bankReport')->get('parcelAmount')->setValue($vehicleProposal->getProposal()->getParcelAmount());
        $form->get('bankReport')->get('parcelValue')->setValue($vehicleProposal->getProposal()->getParcelValue());

        if ($this->request->isPost()) {

            $form->setData($this->request->getPost());

            if ($form->isValid()) {

                $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);

                $post = $this->request->getPost()->bankReport;

                $bank = $em->find('DtlBank\Entity\Bank', $post['bank']);

                $dateFilter = new \DtlBase\Filter\Date();
                $currencyFilter = new \DtlBase\Filter\Currency();

                $baseDate = new \DateTime($dateFilter->filter($vehicleProposal->getProposal()->getBaseDate()));

                $timestamp = $baseDate->getTimestamp();

                $endDate = $baseDate->setDate(date('Y', $timestamp), date('m', $timestamp) + $post['parcelAmount'] + 1, date('d', $timestamp));

                $dataProposal = array(
                    'bank' => $bank,
                    'parcelAmount' => $post['parcelAmount'],
                    'parcelValue' => $currencyFilter->filter($post['parcelValue']),
                    'lastExpiration' => date('Y-m-d', $endDate->getTimestamp()),
                    'isChecking' => true,
                    'isApproved' => false,
                    'isCanceled' => false,
                    'isIntegrated' => false,
                    'isRefused' => false,
                    'isAborted' => false,
                    'lastChange' => date('Y-m-d H:i:s'),
                );

                $proposal = $vehicleProposal->getProposal();
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

                $activeBankReport = $vehicleProposal->getProposal()->getReports();
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
                $proposal->addReport($bankReport);

                $em->persist($proposal);
                $em->persist($vehicleProposal);

                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Migração bancária efetuada com sucesso!');
                return $this->redirect()->toRoute("dtladmin/dtlproposal/vehicle-proposal");
            }
        }

        return array(
            'form' => $form,
            'vehicleProposal' => $vehicleProposal,
        );
    }

    public function listvehiclesAction() {
        $vehicles = array();
        if (!empty($this->getProposalSession()->vehicles)) {
            $vehicles = $this->getProposalSession()->vehicles;
        }
        $view = new ViewModel(array(
            'vehicles' => $vehicles,
        ));
        $view->setTemplate('dtl-proposal/vehicle-proposal/vehicle/listvehicles');
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
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => $vehicle)));
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

    public function searchAction() {
        $form = new \DtlProposal\Form\Search($this->getEntityManager(), $this->identity()->getId());
        return new ViewModel(array(
            'form' => $form,
        ));
    }

    private function getAdvancedSearchResult($query, $post) {
        $params = $post->search;

        if (!empty($params['proposalId'])) {
            $query->andWhere('vp.vehicleProposalId = ' . $params['proposalId']);
        }

        if (!empty($params['proposalStatus'])) {
            $proposalStatus = $params['proposalStatus'];
            switch ($proposalStatus) {
                case 'CHECKING':
                    $query->andWhere('p.isChecking = TRUE');
                    break;
                case 'APPROVED':
                    $query->andWhere('p.isApproved = TRUE');
                    break;
                case 'CANCELED':
                    $query->andWhere('p.isCanceled = TRUE');
                    break;
                case 'ABORTED':
                    $query->andWhere('p.isAborted = TRUE');
                    break;
                case 'INTEGRATED':
                    $query->andWhere('p.isIntegrated = TRUE');
                    break;
                case 'PENDING':
                    $query->andWhere('p.isPending = TRUE');
                    break;
                case 'REFUSED':
                    $query->andWhere('p.isRefused = TRUE');
                    break;
            }
        }

        if (!empty($params['customerName'])) {
            $query->join('p.customer', 'c');
            $query->join('c.person', 'ps');
            $query->andWhere('ps.name LIKE :name');
            $query->setParameter('name', $params['customerName'] . '%');
        }

        if (!empty($params['shopman'])) {
            $query->andWhere('vp.shopman = ' . $params['shopman']);
        }

        if (!empty($params['bank'])) {
            $query->andWhere('p.bank = ' . $params['bank']);
        }

        if (!empty($params['proposalDateFrom']) && !empty($params['proposalDateTo'])) {
            $filter = new \DtlBase\Filter\Date();
            $query->andWhere('p.baseDate BETWEEN :datefrom AND :dateto');
            $query->setParameter('datefrom', $filter->filter($params['proposalDateFrom']));
            $query->setParameter('dateto', $filter->filter($params['proposalDateTo']));
        }

        if (!empty($params['company'])) {
            $query->andWhere('p.company = ' . $params['company']);
        }

        return $query;
    }

    public function calculateValueAction() {
        $filter = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));

        $inValue = $this->params()->fromPost('inValue');
        $totalValue = $this->params()->fromPost('totalValue');

        $value = number_format($filter->filter($totalValue) - $filter->filter($inValue), 2, ',', '.');

        return $this->response->setContent(Json::encode(array('value' => $value)));
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
                ->createQueryBuilder('vp')
                ->select('(vp.proposal) as proposal, p.name AS personName, p.type, l.cnpj, '
                        . 'pr.date, pr.value, pr.parcelAmount, '
                        . 'b.name AS bankName, '
                        . 'i.cpf, a.name as addressName, a.number, '
                        . 'a.quarter, ci.name as city, st.name as state, '
                        . 'ct.email, ct.phone, ct.cell')
                ->join('vp.proposal', 'pr')
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
                $proposal['proposal'],
                $proposal['personName'],
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

        return $this->csvExport('propostas_veiculos_' . date('dmYHis'), $header, $data, null, ';');
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
