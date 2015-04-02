<?php
namespace Vendor;
use Presenter;
use Model;

class System
{
	/**
	 * Nastaví FLASH zprávu
	 * @access public
	 * @return void
	 */
	public function flash( $message ) {
		$_SESSION["flash"] = $message;
	}

	/**
	 * Vykreslí chybu 404
	 * @access public
	 * @return void
	 */
	public function error404()
	{
		$presenter = new Presenter\Error;
		$presenter->render404(); 
	}

	/**
	 * Převede hodnotu na ASCII znaky
	 * @param String[$value] Hodnota
	 * @access public
	 * @return String Převedená hodnota
	 */
	public function convertToASCII( $value )
	{
		return iconv('Windows-1252', 'ASCII//TRANSLIT//IGNORE', $value);
	}

	/**
	 * Vrátí obsah souboru
	 * @access public
	 * @return String Obsah souboru
	 */
	public function getFileContent( $file )
	{
		return file_get_contents( PATH . '/' . $file );
	}
}