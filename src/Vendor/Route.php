<?php
namespace Vendor;

class Route
{	
	/**
	 * Reference na presenter
	 * @access public
	 */
	public $presenter;

	/**
	 * Reference na view
	 * @access public
	 */
	public $view;

	/**
	 * Adresa na cestu
	 * @access public 
	 */
	public $address;

	/**
	 * Proměnné
	 * @access public
	 */
	public $variables;

	/**
	 * Nastaví údaje o cestě
	 * @param String Adresa
	 * @param String Cesta
	 * @access public
	 * @return void
	 */
	public function __construct( $address, $route)
	{
		$this->config = new Config;

		$route = explode(":", $route);
		$address = explode("/", $address);

		$i = 0;
		foreach( $address as $value )
		{
			if( !preg_match("/\<(.*)\>/", $value) ) {
				$this->variables[ $value ] = $value;
			} else
			{
				$value = $this->parseValue( $value );
				$this->variables[ $value ] = $this->getVarValue( $i );
				$address[ $i ] = $this->variables[ $value ];
			}
			$i++;
		}

		$this->presenter = $route[0];
		$this->view = $route[1];
		$this->address = implode("/", $address);
	}

	/**
	 * Vrátí hodnotu proměnné
	 * @param Integer Iterátor
	 * @access private
	 * @return String
	 */
	private function getVarValue( $iterator )
	{
		$address = explode("/", $this->config->address);
		return $address[ $iterator ];
	}

	/**
	 * Odstraní ostré závorky v proměnné
	 * @param String Parsovaná hodnota
	 * @access private
	 * @return String
	 */
	private function parseValue( $value )
	{
		$value = str_replace("<", "", $value);
		$value = str_replace(">", "", $value);
		return $value;
	}
}