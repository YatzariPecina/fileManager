<?php
require "config.php";

/**
 * Regresa una instancia de PDO para poder trabajar con la base de datos.
 */
function getDbConnection() {

	// Opciones para la conexión a DB.
	$options = [
		PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
	];

	// Creamos una instancia de tipo PDO, que es la que regresamos.
	// Los parámetros de conexión a DB están definidos en el archivo config.php.
	return new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, $options);
}
