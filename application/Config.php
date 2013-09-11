<?php
/**
 * Esta constante representa el controlador por defecto de la aplicación.
 * Esto es porque en caso de que no se envié un controlador vía url
 * se lanzará el controlador por defecto.
 */
define('DEFAULT_CONTROLLER', 'index');
/**
 * Vista por defecto.
 */
define('DEFAULT_LAYOUT', 'default');
/**
 * Esta constante se utiliza para incluir archivos del lado de las vistas
 * de usuario.
 */
define('BASE_URL', 'http://localhost/abm/');

define('APP_NAME', 'Framework ABM');
define('APP_SLOGAN', 'Este framework está hecho desde lo más básico.');
define('APP_COMPANY', 'tadeork.com.ar');
define('SESSION_TIME', 10);

define('DB_HOST', 'localhost:3306');
define('DB_USER', 'root');
define('DB_PASS', 'Sorrentin0s');
define('DB_NAME', 'abm');
define('DB_CHAR',  'utf8');

?>
