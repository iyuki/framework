<?php
namespace Presenter;
use Vendor\Pattern as Pattern;
use Component;
use Vendor;

class Login extends Pattern
{
	/**
	 * Component\Login
	 * @access private
	 */
	private $Login;

	/**
	 * Vendor\Auth
	 * @access private
	 */
	private $auth;

	/**
	 * Konstruktor
	 * @access public
	 * @return void
	 */
	public function start()
	{
		$this->Login = new Component\Login;
		$this->auth = new Vendor\Auth;
		$this->Login->actionLogin();
	}

	/**
	 * Odhlásí uživatele
	 * @access public
	 * @return void
	 */
	public function actionLogout()
	{
		$this->auth->logout();
	}

	/**
	 * Vykreslí pohled
	 * @access public
	 * @return void
	 */
	public function renderDefault()
	{
		$this->data["login"] = $this->Login;
		$this->renderView("login/default");
	}
}