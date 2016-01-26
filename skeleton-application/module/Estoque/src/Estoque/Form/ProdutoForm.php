<?php

namespace Estoque\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class ProdutoForm extends Form {

	public function __construct() {
		parent::__construct('form-produto');
		$this->add([
			'type' => 'Text',
			'name' => 'nome',
			'attributes' => [
				'class' => 'form-control'
			]
		]);

		$this->add([
			'type' => 'number',
			'name' => 'preco',
			'attributes' => [
				'class' => 'form-control'
			]
		]);

		$this->add([
			'type' => 'textarea',
			'name' => 'descricao',
			'attributes' => [
				'class' => 'form-control'
			]
		]);
	}
}