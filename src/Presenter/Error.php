<?php
namespace Presenter;
use Vendor\Pattern as Pattern;

class Error extends Pattern
{
	/**
	 * Vykreslí chybu 404
	 * @access public
	 * @return void
	 */
	public function render404() {
		$this->renderView("error/404");
	}
}