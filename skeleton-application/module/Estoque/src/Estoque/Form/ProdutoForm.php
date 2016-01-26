<?php

namespace Estoque\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Doctrine\Common\Persistence\ObjectManager;

class ProdutoForm extends Form {

	public function __construct(ObjectManager $entityManager) {
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

		$this->add([
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'name' => 'categoria',
			'options' => [
				'object_manager' => $entityManager,
				'target_class' => 'Estoque\Entity\Categoria',
				'property' => 'nome',
				'empty_option' => 'Selecione',
			],
			'attributes' => [
				'class' => 'form-control'
			]
		]);
	}
}