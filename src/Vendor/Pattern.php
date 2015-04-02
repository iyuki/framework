<?php
namespace Vendor;
use Vendor;
use Model;

abstract class Pattern
{
	/**
	 * Proměnné, které jsou v šabloně
	 * @access protected
	 */
	public $data = array();

	/**
	 * Reference na konfiguraci
	 * @access private
	 */
	private $config;

	/**
	 * Reference na systém
	 * @access private
	 */
	private $system;

	/**
	 * Konstruktor
	 * @access public
	 * @return void
	 */
	public function __construct() {
		$this->config = new Config;
		$this->system = new System;
		$this->helper = new Helper;

		$this->data["title"] = $this->config->title;
		$this->data["base"] = $this->config->server;
		$this->data["x"] = $this->helper;
	}

	/**
	 * Vykreslí Layup
	 * @access public
	 * @return void
	 */
	public function layup() {
		$this->renderView("layup");
	}

	/**
	 * Načte layout
	 * @access public
	 * @return void
	 */
	public function laydown() {
		$this->renderView("laydown");
	}

	/**
	 * Vykreslí pohled
	 * @param string Jméno pohledu
	 * @return void
	 */
	protected function renderView( $view )
	{
		extract( $this->xssSafer( $this->data ) );
		require PATH . '/View/' . $view . '.phtml';
	}
	
	/**
	 * Přesměruje aplikaci na jinou stránku
	 * @param string URL adresa
	 * @return void
	 */
	protected function redirect( $url )
	{
        header("Location: $url");
        header("Connection: close");
        exit;
	}

	/**
	 * Zabezpečí data vykreslovaná v šabloně
	 * @param string Hodnota proměnné
	 * @return string Zabezpečená proměnná
	 */
	private function xssSafer( $string )
	{
        if (!isset($string))
            return null;
        elseif (is_string($string))
            return htmlspecialchars($string, ENT_QUOTES);
        elseif ((array)$string === $string) // is_array
        {
            foreach($string as $k => $v)
            {
                $string[$k] = $this->xssSafer( $v );
            }
            return $string;
        }
        else
            return $string;
	}

	/**
	 * Nastaví titulek hlavní stránky
	 * @access public
	 * @param String Titulek
	 * @return void
	 */
	public function setTitle( $title, $addOnly = True )
	{
		if( $addOnly == True ) {
			$this->data["title"] .= " | " . $title;
		} else {
			$this->data["title"] = $title;
		}
	}

	/**
	 * Jsem přihlášen?
	 * @access protected
	 * @return Bool
	 */
	protected function isLogged()
	{
		if( isset($_SESSION["logged"]) ) {
			return True;
		} else {
			$this->system->flash("Pro tuto stránku musíš být přihlášen!");
			$this->redirect( $this->config->server );
		}
	}

	/**
	 * Jsem admin?
	 * @access protected
	 * @return Bool
	 */
	protected function isAdmin()
	{
		if( $_SESSION["data"]["admin"] == 1 ) {
			return True;
		} else {
			$this->system->flash("Na tuto stránku smí jen administrátor!");
			$this->redirect( $this->config->server );
		}
	}
}
