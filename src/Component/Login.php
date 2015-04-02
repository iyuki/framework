<?php
namespace Component;
use Vendor\Pattern as Pattern;
use Vendor;

class Login extends Pattern
{
	/**
	 * Konstruktor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->system = new Vendor\System;
		$this->auth = new Vendor\Auth;
		$this->config = new Vendor\Config;
	}

	/**
	 * Přihlášení, akce z formuláře
	 * @access public
	 * @return void
	 */
	public function actionLogin()
	{
		if( isset( $_POST["login"] ) ) {
			if( $this->validate() ) {
				$this->auth->login( $_POST["username"], $_POST["password"] );
			}
		}
	}

	/**
	 * Vykreslí formulář
	 * @access public
	 * @return void
	 */
	public function renderForm()
	{
		if( !$_SESSION["logged"] ) {
			$this->renderView("login/form");
		} else {
			$this->system->flash("Už jsi přihlášen!");
			$this->redirect( $this->config->server );
		}
	}

	/**
	 * Zvaliduje formulář
	 * @access private
	 * @return Boolean
	 */
	private function validate()
	{
		if( $_POST["username"] == "" ) {
			$this->system->flash("Musíš vyplnit uživatelské jméno.");
			return False;
		} elseif( $_POST["password"] == "" ) {
			$this->system->flash("Musíš vyplnit heslo.");
			return False;
		} else {
			return True;
		}
	}
}