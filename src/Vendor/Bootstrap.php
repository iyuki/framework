<?php
namespace Vendor;
use Presenter;

/**
* Bootstrap aplikace
*/
class Bootstrap
{
	/**
	 * Konstruktor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$router = new Presenter\Router;
		$router->run();
	}
}