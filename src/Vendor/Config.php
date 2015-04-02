<?php
namespace Vendor;

/**
 * Konfigurační třída
 */
class Config
{
	/**
	 * Vendor\System
	 * @access private
	 */
	private $system;

	/**
	 * Konstruktor
	 * Decode configuration file
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->system = new System;

		$config = $this->system->getFileContent( "Config\\config.json" );
		$config = json_decode( $config, True );

		foreach( $config as $key => $value ) {
			$this->$key = $value;
		}

		if( $_SERVER['SERVER_NAME'] == "localhost" ) {
			$server = "http://" . $_SERVER['SERVER_NAME'];
		} else {
			$server = $_SERVER['SERVER_NAME'];
		}

		$this->server = $server . "/" . $this->workspace;
		$this->address = $this->parseAddress( $_SERVER['REQUEST_URI'] );
	}

	/**
	 * Vyparsuje adresu
	 * @param String[$address] Adresa 
	 * @access private
	 * @return String[$address] Adresa
	 */
	private function parseAddress( $address )
	{
		$address = preg_replace("/(\?|\&)(.*)\=(.*)/", "", $address);
		$address = trim(str_replace( $this->workspace, "", $address ), "/");
		return $address;
	}
}