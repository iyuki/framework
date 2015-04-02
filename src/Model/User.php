<?php
namespace Model;

class User
{
	/**
	 * Vrátí uživatele podle jména a hesla
	 * @param String[$username] Uživatelské jméno
	 * @param String[$password] Heslo
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function getByUsernameAndPassword( $username, $password )
	{
		return Database::parameters("
			SELECT * FROM `user`
			WHERE
			`name` = ?
			AND
			`password` = ?
		", array($username, $password));
	}

	/**
	 * Vrátí uživatele podle ID
	 * @param Integer[$id] Identifikační číslo 
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function getById( $id )
	{
		return Database::parameters("
			SELECT * FROM `user`
			WHERE
			`id` = ?
		", array($id));
	}

	/**
	 * Změní uživatelské údaje
	 * @param Array()[$values] Nové uživatelské údaje
	 * @access public
	 * @return PDOStatement Výsledek dotazu
	 */
	public function update( $values )
	{
		return Database::parameters("
			UPDATE `user`
			SET
			`name` = :name,
			`description` = :description
			WHERE
			`id` = :id
		", $values);
	}
}