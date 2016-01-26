<?php

namespace Estoque\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;

/** @ORM\Entity */
class Categoria {

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
	 * @ORM\OneToMany(targetEntity="Estoque\Entity\Produto", mappedBy="categoria")
	 */
	private $produto;


	public function setNome($nome) {
		$this->nome = $nome;
	}

	public function getNome() {
		return $this->nome;
	}

	public function getId() {
		return $this->id;
	}
}