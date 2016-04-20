<?php

namespace DtlUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Zend\Paginator\Paginator;
use DtlUser\Form\User as UserForm;
use DtlUser\Form\UserEdit as UserEditForm;
use DtlUser\Entity\User as UserEntity;

class UserController extends AbstractActionController {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager = null;

    /**
     * @var string
     */
    protected $repository = null;

    public function indexAction() {

        $identity = $this->identity();

        $query = $this->getEntityManager()
                ->getRepository($this->getRepository())
                ->createQueryBuilder('u')
                ->having('u.state = 1')
                ->where('u.id = ' . $identity->getId())
                ->orWhere('u.parent = ' . $identity->getId())
                ->orderBy('u.displayName', 'ASC');

        $adapter = new DoctrineAdapter(new DoctrinePaginator($query));

        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);

        $page = $this->params()->fromRoute('page');

        if ($page) {
            $paginator->setCurrentPageNumber($page);
        }

        return new ViewModel(array(
            'users' => $paginator
        ));
    }

    public function addAction() {
        $form = new UserForm($this->getEntityManager());
        $user = new UserEntity();
        $form->bind($user);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $sm = $this->getServiceLocator();
                $service = $sm->get('dtluser_user_service');
                $service->register($post->toArray(), $form->getData());
                $this->flashMessenger()->addSuccessMessage('Usuário cadastrado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtluser');
            }
        }
        $view = new ViewModel(array(
            'form' => $form,
        ));
        return $view;
    }

    public function editAction() {
        $id = $this->params()->fromRoute('id');
        $user = $this->getEntityManager()->find($this->getRepository(), $id);
        $form = new UserEditForm($this->getEntityManager());
        $form->bind($user);
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $form->setData($post);
            if ($form->isValid()) {
                $sm = $this->getServiceLocator();
                $service = $sm->get('dtluser_user_service');
                $service->update($user);
                $this->flashMessenger()->addSuccessMessage('Usuário atualizado com sucesso!');
                return $this->redirect()->toRoute('dtladmin/dtluser');
            }
        }
        $view = new ViewModel(array(
            'form' => $form,
            'user' => $user,
        ));
        return $view;
    }

    public function deleteAction() {
        $id = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $user = $em->find($this->getRepository(), $id);
        if ($this->getRequest()->isPost()) {
            $del = $this->request->getPost('del', 'Não');
            if ($del == 'Sim') {
                $user->setState(0);
                $em->persist($user);
                $em->flush();
                $this->flashMessenger()->addSuccessMessage('Usuário excluído com sucesso!');
            }
            return $this->redirect()->toRoute('dtladmin/dtluser');
        }
        $view = new ViewModel(array(
            'user' => $user,
        ));
        return $view;
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function getRepository() {
        return $this->repository;
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    public function setRepository($repository) {
        $this->repository = $repository;
        return $this;
    }

}
