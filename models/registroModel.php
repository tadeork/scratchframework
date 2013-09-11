<?php

/**
 * Modelo para crearle una cuenta a un nuevo usuario.
 */
class registroModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Se verifica si el usuario que quiere registrarse está ingresando
     * un nombre de usuario de otro user que tiene el mismo nombre de usuario.
     */
    public function verificarUsuario($usuario) {
        /*
         * Para eso debe consultar en la BD.
         */
        $id = $this->_db->query(
                "select id from usuarios where usuario = '$usuario'"
        );

        if ($id->fetch()) {
            return true;
        }

        return false;
    }

    /**
     * Realiza la misma validación que el username.
     * @param type $email
     * @return boolean
     */
    public function verificarEmail($email) {
        $id = $this->_db->query(
                "select id from usuarios where email = '$email'"
        );

        if ($id->fetch()) {
            return true;
        }
        return false;
    }

    /**
     * Pasadas las validaciones anteriores crea la cuenta.
     * @param type $nombre
     * @param type $usuario
     * @param type $password
     * @param type $email
     */
    public function registrarUsuario($nombre, $usuario, $password, $email) {
        /*
         * Por defecto se están guardando usuarios con roles de 'usuario'
         */
        $this->_db->prepare(
                        "insert into usuarios values" .
                        "(null, :nombre, :usuario, :password, :email, 'usuario', 1, now())"
                )
                ->execute(array(
                    ':nombre' => $nombre,
                    ':usuario' => $usuario,
                    ':password' => Hash::getHash('sha1', $password, HASH_KEY),
                    ':email' => $email,
        ));
    }

}

?>
