<?php

namespace DtlProposal\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use Zend\Json\Json;
use DtlProposal\Form\RealtyProposal as RealtyProposalForm;

class RealtyProposalController extends AbstractActionController {

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

    /**
     *
     * @var RealtyProposalForm
     */
    protected $form;

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
        $user = $this->identity();
        $form = $this->getForm();
        $realty = new \DtlProposal\Entity\RealtyProposal();

        $prePost = $this->getProposalSession()->prePost['preProposal'];

        if (isset($prePost['cpf'])) {
            $document = $prePost['cpf'];
        } else {
            $document = $prePost['cnpj'];
        }

        $customer = $this->findCustomer($document);

        if ($customer && (!$this->request->isPost())) {
            $customer->setUser($user);
            $realty->getProposal()->setCustomer($customer);
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($realty, $customer);
        }

        $form->bind($realty);
        $form->get('realtyProposal')->get('proposal')->get('customer')->get('person')->setValue($prePost['type']);
        if ($prePost['type']) {
            $form->get('realtyProposal')->get('proposal')->get('customer')->get('person')->get('legal')->get('cnpj')->setValue($document);
        } else {
            $form->get('realtyProposal')->get('proposal')->get('customer')->get('person')->get('individual')->get('cpf')->setValue($document);
        }
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $realty->getProposal()->setUser($user);
                $this->getProposalService()->save($realty);
                $this->flashMessenger()->addSuccessMessage('Proposta cadastrada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal');
            }
        }
        return array(
            'form' => $form,
            'post' => $this->getProposalSession()->prePost,
            'entityManager' => $this->getEntityManager()
        );
    }

    public function editAction() {
        $realtyId = $this->params()->fromRoute('id');
        $form = $this->getForm();
        $em = $this->getEntityManager();
        $realty = $em->find($this->getRepository(), $realtyId);

        if (!$this->request->isPost()) {
            $this->getProposalService()->resetSession();
            $this->getProposalService()->populate($realty, $realty->getProposal()->getCustomer());
        }

        $form->bind($realty);
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $this->getProposalService()->update($realty);
                $this->flashMessenger()->addSuccessMessage('Proposta atualizada com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtlproposal/realty-proposal');
            }
        }

        return array(
            'form' => $form,
            'realtyProposal' => $realty,
            'entityManager' => $this->getEntityManager()
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
        $form = new \DtlProposal\Form\ProposalStatus($em);
        $form->bind($realtyProposal->getProposal());
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->getProposalService()->changeStatus($realtyProposal, $this->request->getPost()->proposalStatus);
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
        $form->get('bankReport')->get('parcelAmount')->setValue($realtyProposal->getProposal()->getParcelAmount());
        $form->get('bankReport')->get('parcelValue')->setValue($realtyProposal->getProposal()->getParcelValue());

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->getProposalService()->changeBank($realtyProposal, $this->request->getPost()->bankReport);
                $this->flashMessenger()->addSuccessMessage('Migração bancária efetuada com sucesso na proposta nº ' . $realtyProposal->getId() . ' com sucesso!');
                return $this->redirect()->toRoute("dtladmin/dtlproposal/realty-proposal");
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
                $proposal->addLog($log);

                $activeBankReport = $realtyProposal->getProposal()->getReports();
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

                $realtyProposal->addEvaluation($form->getData());
                $inValue = $realtyProposal->getValue() - $realtyProposal->getProposal()->getValue();
                $realtyProposal->setInValue($inValue);

                $em->persist($realtyProposal);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Avaliação do imóvel efetuada com sucesso!');
                return $this->redirect()->toRoute("dtladmin/dtlproposal/realty-proposal");
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

                $activeBankReport = $realtyProposal->getProposal()->getReports();
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
                $proposal->addReport($bankReport);

                $em->persist($proposal);
                $em->persist($evaluation);

                $inValue = $realtyProposal->getValue() - $realtyProposal->getProposal()->getValue();
                $realtyProposal->setInValue($inValue);

                $em->persist($realtyProposal);
                $em->flush();

                $this->flashMessenger()->addSuccessMessage('Avaliação do imóvel atualizada com sucesso!');
                return $this->redirect()->toRoute("dtladmin/dtlproposal/realty-proposal");
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
        $storeFolder = 'C:/server/www/vallorisa/public/uploads';
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
            return $this->redirect()->toUrl('/admin/proposal/realty-proposal/1/view/' . $realtyProposal->getId());
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

    public function getForm() {
        return $this->form;
    }

    public function setForm($form) {
        $this->form = $form;
        return $this;
    }

}
