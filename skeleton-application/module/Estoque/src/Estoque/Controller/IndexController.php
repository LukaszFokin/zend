<?php

namespace Estoque\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

	public function IndexAction() {
		$entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$repositorio = $entityManager->getRepository('Estoque\Entity\Produto');
		$produtos = $repositorio->findAll();

		$mensagem = "Beeeeeeeeem Vindooooooooooooooo";

		$params = array(
			'mensagem' => $mensagem,
			'produtos' => $produtos
		);
		
		return new ViewModel($params);
	}
}