<?php
session_start();
mb_internal_encoding('UTF-8');
error_reporting(E_ALL^E_NOTICE);

define( "PATH", __DIR__ );

/**
 * Autoload funkce
 * Model/Presenter/Vendor
 */
spl_autoload_register( function( $class ) {
	$class = str_replace('\\', '/', $class);
	$file = __DIR__  . '\\' . $class . '.php';
	if( file_exists( $file ) ) {
		require $file;
	} else {
		throw new Exception("Class $file does not exist!");
	}
});

$config = new Vendor\Config;

// Připojení k databázi
if( $config->db["dbname"] != "" ) {
	Model\Database::connect(
		$config->db["host"],
		$config->db["dbname"],
		$config->db["username"],
		$config->db["password"]
	);
}

// Spuštění aplikace
$bootstrap = new Vendor\Bootstrap;

// Odstraní flash zprávu
unset($_SESSION["flash"]);