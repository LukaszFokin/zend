<?php

namespace Estoque\Helper\View;

use Zend\View\Helper\AbstractHelper;


class PaginationHelper extends AbstractHelper {

	private $url, $totalProdutos, $qtdPagina;

	public function __invoke($produtos, $qtdPagina, $url) {
		$this->url = $url;
		$this->qtdPagina = $qtdPagina;
		$this->totalProdutos = $produtos->count();

		return $this->gerarPaginacao();
	}
	
	private function gerarPaginacao() {
		$totalPaginas = ceil($this->totalProdutos / $this->qtdPagina);
		$count = 1;
		$html = "<ul class='nav nav-pills'>";
		
		while($count <= $totalPaginas) {
			$html .= "<li><a href='{$this->url}/{$count}'>{$count}</a></li>";
			$count++;
		}
		
		$html .= "</ul>";

		return $html;
	}
}