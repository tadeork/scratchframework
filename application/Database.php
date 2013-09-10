<?php
/**
 * PDO provee una forma genérica de consultar bases de datos.
 * La conexión se realiza a través de un controlador específico para
 * cada motor de base de dato. En este caso PDO tiene incluido el 
 * controlador para MySql.
 */
class Database extends PDO{
    public function __construct() {
        parent::__construct(
                'mysql:host=' . DB_HOST .
                ';dbname=' . DB_NAME,
                DB_USER, 
                DB_PASS, 
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . DB_CHAR
                    ));
    }
}
?>
