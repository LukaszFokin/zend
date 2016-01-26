<?php

namespace Estoque\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Estoque\Entity\Produto;
use Estoque\Entity\Categoria;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class IndexController extends AbstractActionController {

	public function indexAction() {
		$pagina = $this->params()->fromRoute('page');
		if(is_null($pagina))
			$pagina = 1;

		$qtdPorPagina = 3;
		$offset = ($pagina - 1) * $qtdPorPagina;

		$entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$repositorio = $entityManager->getRepository('Estoque\Entity\Produto');
		$produtos = $repositorio->getProdutosPaginados($qtdPorPagina, $offset);
		//$produtos = $repositorio->findAll();

		$params = array(
			'produtos' => $produtos,
			'qtdPorPagina' => $qtdPorPagina
		);

		return new ViewModel($params);
	}

	public function createAction() {

		if(!$user = $this->identity()) {
			return $this->redirect()->toUrl('/Usuario/index');
		}

		$entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$categoriaEntity = $entityManager->getRepository('Estoque\Entity\Categoria');
		$form = new \Estoque\Form\ProdutoForm($entityManager);
		
		if($this->request->isPost()) {
			$categoria = $categoriaEntity->find($this->request->getPost('categoria'));
			$produto = new Produto();
			$produto->setCategoria($categoria);

			$form->setInputFilter($produto->getInputFilter());
			$form->setData($this->request->getPost());

			if($form->isValid()) {
				$produto->setNome($this->request->getPost('nome'));
				$produto->setPreco($this->request->getPost('preco'));
				$produto->setDescricao($this->request->getPost('descricao'));

				$entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
				$entityManager->persist($produto);
				$entityManager->flush();

				return $this->redirect()->toUrl('/Index/index');
			}
		}
		
		return new ViewModel(['form' => $form]);
	}

	public function deleteAction() {
		$id = $this->params()->fromRoute('id');

		if($this->request->isPost()) {
			$id = $this->request->getPost('id');

			$entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
			$repositorio = $entityManager->getRepository('Estoque\Entity\Produto');
			$produto = $repositorio->find($id);

			$entityManager->remove($produto);
			$entityManager->flush();

			$this->flashMessenger()->addMessage('Produto #'.$produto->getId(). ' deletado com sucesso.');

			return $this->redirect()->toUrl('/Index/index');
		}

		return new ViewModel(['id' => $id]);
	}

	public function updateAction() {
		$id = $this->params()->fromRoute('id');
		if(is_null($id))
			$id = $this->request->getPost('id');

		$entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$repositorio = $entityManager->getRepository('Estoque\Entity\Produto');
		$categoriaRepositorio = $entityManager->getRepository('Estoque\Entity\Categoria');

		$form = new \Estoque\Form\ProdutoForm($entityManager);
		$produto = $repositorio->find($id);

		if($this->request->isPost()) {
			$categoria = $categoriaRepositorio->find($this->request->getPost('categoria'));

			$produto->setNome($this->request->getPost('nome'));
			$produto->setPreco($this->request->getPost('preco'));
			$produto->setDescricao($this->request->getPost('descricao'));
			$produto->setCategoria($categoria);

			$entityManager->persist($produto);
			$entityManager->flush();

			/*
			$this->flashMessenger()->addMessage('Produto #'.$produto->getId(). ' alterado com sucesso.');
			$this->flashMessenger()->addErrorMessage('Produto #'.$produto->getId(). ' alterado com sucesso.');
			$this->flashMessenger()->addWarningMessage('Produto #'.$produto->getId(). ' alterado com sucesso.');
			*/
			$this->flashMessenger()->addSuccessMessage('Produto #'.$produto->getId(). ' alterado com sucesso.');

			return $this->redirect()->toUrl('/Index/index');	
		}

		return new ViewModel(['produto' => $produto, 'form' => $form]);
	}

	public function contactAction() {
		if($this->request->isPost()) {
			$nome = $this->request->getPost('nome');
			$email = $this->request->getPost('email');
			$mensagem = $this->request->getPost('mensagem');
		
			$msgHtml = "
				<b>Nome:</b> {$nome}<br>,
				<b>Email:</b> {$email}<br>,
				<b>Mensagem:</b> {$mensagem}<br>";


			$htmlPart = new MimePart($msgHtml);
			$htmlPart->type = 'text/html';

			$htmlMsg = new MimeMessage();
			$htmlMsg->addPart($htmlPart);

			$email = new Message();
			$email->addTo('lukasz.fokin@gmail.com');
			$email->setSubject('Contato do site');
			$email->addFrom('lukasz.fokin@gmail.com');
			$email->setBody($htmlMsg);

			$config = array (
				'host' => 'smtp.gmail.com',
				'connection_class' => 'login',
				'connection_config' => array(
					'ssl' => 'tsl',
					'username' => 'lukasz.fokin@gmail.com',
					'password' => ''
				)
			);
			$transport = new SmtpTransport();
			$transport->setOptions(new SmtpOptions($config));

			$this->flashMessenger()->addSuccessMessage('Contato enviado com sucesso');

			return $this->redirect()->url('/Index/index');
		}

		return new ViewModel();
	}
}