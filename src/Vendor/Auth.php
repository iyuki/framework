<?php
namespace Vendor;
use Model;

class Auth extends Pattern
{
	/**
	 * Uživatelská data
	 * @access private
	 */
	public $data;

	/**
	 * Model\User
	 * @access private
	 */
	private $user;

	/**
	 * Vendor\System
	 * @access private
	 */
	private $system;

	/**
	 * Konstruktor
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->user = new Model\User;
		$this->system = new System;
		$this->config = new Config;
	}

	/**
	 * Vrátí uživatelovi data
	 * @access public
	 * @return Array([$this->data] / String[$data] Uživatelská data
	 */
	public function getData( $target = "" )
	{
		if( $target == "" ) {
			return $this->data;
		} else {
			return $this->data[ $target ];
		}
	}

	/**
	 * Přihlásí uživatele
	 * @param String[$username] Uživatelské jméno
	 * @param String[$password] Heslo
	 * @access public
	 * @return void
	 */
	public function login( $username, $password )
	{
		$query = $this->user->getByUsernameAndPassword( $username, $this->hash($password) )->fetch();

		if( $query ) {
			$_SESSION["logged"] = True;
			$_SESSION["data"] = $query;
			$this->system->flash("Jsi přihlášen(a).");
			$this->redirect( $this->config->server );
		} else {
			$this->system->flash("Špatné jméno nebo heslo.");
			$this->redirect("");
		}
	} 

	/**
	 * Odhlásí uživatele
	 * @access public
	 * @return void
	 */
	public function logout()
	{
		unset( $_SESSION["logged"] );
		unset( $_SESSION["data"] );
		$this->system->flash("Byl jsi odhlášen.");
		$this->redirect( $this->config->server );
	}

	/**
	 * Zahashuje heslo
	 * @param String[$password] Heslo
	 * @param String[$salt] Sůl
	 * @access public
	 * @return String Zahashované heslo
	 */
	public function hash( $password, $salt = "7joaiu")
	{
		return hash( "sha1", $password . $salt );
	}
}