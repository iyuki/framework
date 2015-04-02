<?php
namespace Model;

class Database
{
	/**
	 * Datový člen obsahující instanci PDO
	 * @access public
	 */
	public static $connection;

	/**
	 * Připojí k databázi
	 * @access public
	 * @param string Hostitel
	 * @param string Název databáze
	 * @param string Uživatelské jméno
	 * @param string Heslo
	 * @return void
	 */
	public static function connect( $host, $dbname, $user, $password )
	{
		if( !isset( self::$connection ) )
		{
			self::$connection = new \PDO(
				"mysql:
				 host=$host;
				 dbname=$dbname",
				 $user,
				 $password
			);
		}
	}

	/**
	 * Vykoná jednoduchý příkaz bez parametrů
	 * @access public
	 * @param string Dotaz
	 * @return PDOStatement Výsledek dotazu
	 */
	public static function simple( $query )
	{
		$sql = self::$connection->query( $query );
		return $sql;
	}

	/**
	 * Vykoná dotaz s parametry
	 * @access public
	 * @param string Dotaz
	 * @param array Parametry dotazu
	 * @return PDOStatement Výsledek dotazu
	 */
	public static function parameters( $query, $parameters = array() )
	{
		$sql = self::$connection->prepare( $query );
		$sql->execute( $parameters );

		return $sql;
	}
}
