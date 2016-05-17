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
        $user = $this->identity();
        $form = new VehicleProposalForm($this->getEntityManager(), $this->dtlUserMasterIdentity()->getId());
        $vehicleProposal = new \DtlProposal\Entity\VehicleProposal();
        $em = $this->getEntityManager();

        $prePost = $this->getProposalSession()->prePost['preProposal'];

        if (isset($prePost['cpf'])) {
            $document = $prePost['cpf'];
        } else {
            $document = $prePost['cnpj'];
        }

        $customer = $this->findCustomer($document);

        if ($customer && (!$this->request->isPost())) {
            $customer->setUser($user);
            $vehicleProposal->getProposal()->setCustomer($customer);
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($vehicleProposal, $customer);
        }

        $form->bind($vehicleProposal);
        $form->get('vehicleProposal')->get('proposal')->get('customer')->get('person')->setValue($prePost['type']);
        if ($prePost['type']) {
            $form->get('vehicleProposal')->get('proposal')->get('customer')->get('person')->get('legal')->get('cnpj')->setValue($document);
        } else {
            $form->get('vehicleProposal')->get('proposal')->get('customer')->get('person')->get('individual')->get('cpf')->setValue($document);
        }
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $sessionContainer = $this->getProposalSession();
                $doctrineHydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);

                $vehicles = $sessionContainer->vehicles;
                if (count($vehicles) > 0) {
                    foreach ($vehicles as $vehicleData) {
                        $vehicle = new \DtlVehicle\Entity\Vehicle();
                        $doctrineHydrator->hydrate($vehicleData, $vehicle);
                        $vehicleProposal->addVehicle($vehicle);
                    }
                }
                $vehicleProposal->getProposal()->setUser($user);
                $this->getProposalService()->save($vehicleProposal);
                $this->flashMessenger()->addSuccessMessage('Proposta cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/vehicle-proposal');
            }
        }
        return array(
            'form' => $form,
            'post' => $this->getProposalSession()->prePost,
            'entityManager' => $this->getEntityManager()
        );
    }

    public function editAction() {
        $vehicleProposalId = $this->params()->fromRoute('id');
        $form = new VehicleProposalForm($this->getEntityManager(), $this->dtlUserMasterIdentity()->getId());
        $em = $this->getEntityManager();
        $vehicleProposal = $em->find($this->getRepository(), $vehicleProposalId);

        if (!$this->request->isPost()) {
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($vehicleProposal, $vehicleProposal->getProposal()->getCustomer());
            $this->getProposalService()->addProposalVehicles($vehicleProposal);
        }

        $form->bind($vehicleProposal);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $sessionContainer = $this->getProposalSession();
                $doctrineHydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($em);

                $vehicles = $sessionContainer->vehicles;
                if (count($vehicles) > 0) {
                    foreach ($vehicles as $vehicleData) {
                        if (!$vehicleData['id']) {
                            $vehicle = new \DtlVehicle\Entity\Vehicle();
                            $doctrineHydrator->hydrate($vehicleData, $vehicle);
                            $vehicleProposal->addVehicle($vehicle);
                        }
                    }
                }

                $this->getProposalService()->update($vehicleProposal);
                $this->flashMessenger()->addSuccessMessage('Proposta atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/vehicle-proposal');
            }
        }

        return array(
            'form' => $form,
            'vehicleProposal' => $vehicleProposal,
            'entityManager' => $this->getEntityManager()
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

        $form = new \DtlProposal\Form\ProposalStatus($em);
        $form->bind($vehicleProposal->getProposal());
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->getProposalService()->changeStatus($vehicleProposal, $this->request->getPost()->proposalStatus);
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
                $this->getProposalService()->changeBank($vehicleProposal, $this->request->getPost()->bankReport);
                $this->flashMessenger()->addSuccessMessage('Migração bancária efetuada com sucesso na proposta nº ' . $vehicleProposal->getId() . ' com sucesso!');
                return $this->redirect()->toRoute("dtladmin/dtlproposal/vehicle-proposal");
            }
        }

        return array(
            'form' => $form,
            'vehicleProposal' => $vehicleProposal
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
        if (empty($vehicle['brand']) ||
                empty($vehicle['type']) ||
                empty($vehicle['model']) ||
                empty($vehicle['version'])) {
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => false)));
        } else {
            $em = $this->getEntityManager();
            $currency = new \Zend\I18n\Filter\NumberFormat(array('locale' => 'pt_BR'));
            $brand = $em->find('DtlVehicle\Entity\VehicleBrand', $vehicle['brand']);
            $type = $em->find('DtlVehicle\Entity\VehicleType', $vehicle['type']);
            $model = $em->find('DtlVehicle\Entity\VehicleModel', $vehicle['model']);
            $version = $em->find('DtlVehicle\Entity\VehicleVersion', $vehicle['version']);
            $vehicle['brandName'] = $brand->getName();
            $vehicle['typeName'] = $type->getName();
            $vehicle['modelName'] = $model->getName();
            $vehicle['versionName'] = $version->getName();
            $vehicle['value'] = $currency->filter($vehicle['value']);
            $this->getProposalSession()->vehicles[] = $vehicle;
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => $vehicle)));
        }
    }

    public function deletevehicleAction() {
        $item = (int) $this->params()->fromQuery('itemId');
        $dataId = (int) $this->params()->fromQuery('dataId');
        $vehicles = $this->getProposalSession()->vehicles;
        if ($item >= 0) {
            unset($vehicles[$item]);
            $this->getProposalSession()->vehicles = $vehicles;
            if (!empty($dataId)) {
                $em = $this->getEntityManager();
                $vehicle = $em->find('DtlVehicle\Entity\Vehicle', $dataId);
                $em->remove($vehicle);
                $em->flush();
            }
            return $this->getResponse()->setContent(\Zend\Json\Json::encode(array('result' => true)));
        }
    }

    public function searchAction() {
        $form = new \DtlProposal\Form\Search($this->getEntityManager(), $this->identity()->getId());
        return new ViewModel(array(
            'form' => $form,
        ));
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

    public function setProposalService(\DtlProposal\Service\ProposalService $proposalService) {
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
