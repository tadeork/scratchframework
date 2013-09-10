<?php
/**
 * De esta clase van a extender todos los modelos que necesiten
 * acceder a la DB.
 */
class Model{
    protected $_db;
    
    public function __construct() {
        $this->_db = new Database();
    }
}
?>
