<?php

namespace Estoque\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Produto {

	/** 
	* @ORM\id
	* @ORM\GeneratedValue(strategy="AUTO")
	* @ORM\Column(type="integer")
	*/
	private $id;

	/**
	 * @ORM\Column(type="string")
	 */
	private $nome;

	/**
	 * @ORM\Column(type="decimal", scale=2)
	 */
	private $preco;

	/**
	 * @ORM\Column(type="string")
	 */
	private $descricao;

	public function getNome() {
		return $this->nome;
	}

	public function getPreco() {
		return $this->preco;
	}

	public function getDescricao() {
		return $this->descricao;
	}
}