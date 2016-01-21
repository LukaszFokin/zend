<?php

namespace Estoque\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UsuarioController extends AbstractActionController {

	public function indexAction() {
		return new ViewModel();
	}

	public  function loginAction() {
		
		if($this->request->isPost()) {

		$dados = $this->request->getPost();

		$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		$authAdapter = $authService->getAdapter();
		$authAdapter->setIdentityValue($dados['email']);
		$authAdapter->setCredentialValue($dados['senha']);

		$authResult = $authService->authenticate();

		if($authResult->isValid()) {
			return $this->redirect()->toUrl('Index/create');
		}

		$this->flashMessenger()->addErrorMessage("Login ou senha inválido");
		return $this->redirect()->toUrl('/Usuario/Index');

		}

		return new ViewModel();

	}
}