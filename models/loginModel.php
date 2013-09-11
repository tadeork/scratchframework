<?php

class loginModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    /**
     * Consulta en la base de datos la existencia de un usuario.
     * @param type $usuario
     * @param type $password
     * @return type
     */
    public function getUsuario($usuario, $password){
        $datos = $this->_db->query(
                "select * from usuarios " .
                "where usuario = '$usuario' " .
                "and pass = '" . Hash::getHash('sha1',$password, HASH_KEY) ."'"
                );
        return $datos->fetch();
    }
    
}

?>
