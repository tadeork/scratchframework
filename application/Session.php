<?php

/**
 * Esta clase nos va a proporcionar los métodos para 
 * manejar variables de sesión. Con esta clase tenemos mayor nivel de seguridad
 */
class Session {

    public static function init() {
        session_start();
    }

    /**
     * Termina una sesión o sesiones.
     * @param type $clave
     */
    public static function destroy($clave = false) {
        if ($clave) {
            /**
             * revisa si es un arreglo
             */
            if (is_array($clave)) {
                for ($i = 0; $i < count($clave); $i++) {
                    if (isset($_SESSION[$clave[$i]])) {
                        /*
                         * Por cada coinidencia elimina tal sesión
                         */
                        unset($_SESSION[$clave[$i]]);
                    }
                }
            } else {
                if (isset($_SESSION[$clave])) {
                    unset($_SESSION[$clave]);
                }
            }
        } else {
            session_destroy();
        }
    }

    /**
     * Asigna un valor a la variable de sesión.
     * @param type $clave
     * @param type $valor
     */
    public static function set($clave, $valor) {
        if (!empty($clave)) {
            $_SESSION[$clave] = $valor;
        }
    }
    
    /**
     * A partir de una clave obtenemos la variable de sesión.
     * @param type $clave
     * @return type
     */
    public static function get($clave){
        if(isset($_SESSION[$clave])){
            return $_SESSION[$clave];
        }
    }
    
    /**
     * echo '<pre>';
        print('especial');
        echo '</pre>';
        die();
     * Nivel de usuario mínimo requerido
     * para que la función de permiso para acceeder.
     * @param type $level
     */
    public static function acceso($level){
        
        if(!Session::get('autenticado')){
            header('location:'. BASE_URL . 'error/access/5050');
            exit();
        }
        
        Session::tiempo();
        
        /*
         * Pregunta por el nivel de acceso del usuario dado en una sesión.
         * Si es mayor al del usuario no lo dejará pasar.
         */
        if(Session::getLevel($level) > Session::getLevel(Session::get('level'))){
            header('location:' . BASE_URL . 'error/access/5050');
            exit();
        }
    }

    /**
     * Con este método se va a restringir el acceso a ciertas partes de las vistas.
     * A diferencia de acceso aquí no redirecciona sino que no muestra ciertas partes
     * del código.
     * @param type $level
     * @return boolean
     */
    public static function accesosView($level){
        if(!Session::get('autenticado')){
            return false;
        }
        
        /*
         * Pregunta por el nivel de acceso del usuario dado en una sesión.
         * Si es mayor al del usuario no lo dejará pasar.
         */
        if(Session::getLevel($level) > Session::getLevel(Session::get('level'))){
            return false;
        }
        
        return true;
    }

    /**
     * Desde este método podemos obtener los diferentes 
     * niveles de acceso por usuario. getLevel será 
     * accedido por  otros métodos, por eso lo hacemos 
     * aparte para que sean controlados desde un sólo punto.
     * @param type $level
     */
    public static function getLevel($level){
        $role['admin'] = 3;
        $role['especial'] = 2;
        $role['usuario'] = 1;
        
        /*
         * En caso de que no exista el nivel de acceso que
         * se está introduciendo. Se lo busca a través de la 
         * clave rol.
         */
        if(!array_key_exists($level, $role)){
            throw new Exception('Error de acceso');
        } else{
            return $role[$level];
        }
    }
    
    /**
     * Este método permite seleccionar grupos de usuarios
     * específicos para otorgar permisos por grupos.
     * @param type $level nivel de acceso.
     * @param type $noAdmin
     */
    public static function accesoEstricto(array $level, $noAdmin = FALSE){
        if(!Session::get('autenticado')){
            header('location:' . BASE_URL . 'error/access/5050');
            exit();
        }
        
        Session::tiempo();
        
        /*
         * En caso de que sí se envía verdadero
         * entonces el amdin no tiene acceso.
         */
        if($noAdmin == FALSE){
            if(Session::get('level') == 'admin'){
                return;
            }
        }
        
        if(count($level)){
            /*
             * Si existe el nivel del usuario en arreglo
             * lo deja pasar.
             */
            if(in_array(Session::get('level'), $level)){
                return;
            }
        }
        header('location:' . BASE_URL . 'error/access/5050');
    }
    
    /**
     * Lo mismo que el método anterior pero para restringir código de las vistas,
     * por lo que no necesita redireccionar.
     * @param array $level
     * @param type $noAdmin
     */
    public static function accesoViewEstricto(array $level, $noAdmin = FALSE){
        if(!Session::get('autenticado')){
            return false;
        }
        /*
         * En caso de que sí se envía verdadero
         * entonces el amdin no tiene acceso.
         */
        if($noAdmin == FALSE){
            if(Session::get('level') == 'admin'){
                return true;
            }
        }
        
        if(count($level)){
            /*
             * Si existe el nivel del usuario en arreglo
             * lo deja pasar.
             */
            if(in_array(Session::get('level'), $level)){
                return true;
            }
        }
        return false;
    }
    
    /**
     * Con este método se valida cuánto tiempo lleva logeado un usuario.
     * @return type
     * @throws Exception
     */
    public static function tiempo(){
        /*
         * Para asegurarnos que existe un tiempo definido y para 
         * que el usuario todavía tenga tiempo.
         */
        if(!Session::get('tiempo') || !defined('SESSION_TIME')){
            throw new Exception('No se ha definido el tiempo de sesión');
        }
        /*
         * Cuando el tiempo de sesión es cero la aplicación asume que
         * el tiempo de sesión es indefinido.
         */
        if(SESSION_TIME == 0){
            return;
        }
        /*
         * Le restamos la hora actual a la hora en la que el usuario
         * inició sesión. Si es mayor cierra la sesión y redirecciona.
         */
        if(time() - Session::get('tiempo') > (SESSION_TIME * 60)){
            Session::destroy();
            header('location:' . BASE_URL . 'error/access/8080');
        } else {
            /*
             * Si aún está dentro del tiempo va a re iniciar ese tiempo.
             */
            Session::set('tiempo', time());
        }
    }

}

?>
