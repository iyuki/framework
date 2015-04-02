<?php
namespace Presenter;
use Vendor;
use Model;

class Router
{
	/**
	 * Cesty
	 * @access private
	 */
	private $routes = array();

	/**
	 * Reference na presenter
	 * @access private
	 */
	private $presenter;

	/**
	 * Systémová třída
	 * @access private
	 */
	private $system;

	/**
	 * Model\Community
	 * @access private
	 */
	private $community;

	/**
	 * Konstruktor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->config = new Vendor\Config;
		$this->system = new Vendor\System;
	}

	/**
	 * Načte cesty z JSON
	 * @access public
	 * @return void
	 */
	public function loadRoutes()
	{
		$route_setting = $this->system->getFileContent( "Config\\routes.json" );
		$route_setting = json_decode( $route_setting, True );

		foreach( $route_setting as $key => $value) {
			$this->routes[] = new Vendor\Route( $key, $value );
		}
	}

	/**
	 * Nastavení cest
	 * @access public
	 * @return void
	 */
	public function run()
	{
		$this->loadRoutes();

		foreach( $this->routes as $route ) {
			if( $route->address == $this->config->address ) {

				$presenterName = "Presenter\\" . $route->presenter;
				$this->presenter = new $presenterName;
				$this->presenter->var = $route->variables;
				$this->view = $route->view;

			}
		}

		if( empty($this->presenter) ) {
			$this->presenter = new Error;
			$this->view = "404";
		}

		$this->presenterMethods();
	}

	/** 
     * Důležité metody presenteru
     * @access private
     * @return void
     */
	private function presenterMethods()
	{
		if(method_exists($this->presenter, "start")) {
			$this->presenter->start();
		}

		$action = "action" . $this->view;
		if(method_exists($this->presenter, $action)) {
			$this->presenter->$action();
		}

		$this->presenter->layup();

		$render = "render" . $this->view;
		if(method_exists($this->presenter, $render)) {
			$this->presenter->$render();
		}

		if(method_exists($this->presenter, "end")) {
			$this->presenter->end();
		}

		$this->presenter->laydown();
	}
}