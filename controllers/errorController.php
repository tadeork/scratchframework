<?php

class errorController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        /*
         * Asignamos el título a la página de errores.
         */
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = $this->_getError();
        $this->_view->renderizar('index');
    }    
    
    private function _getError($codigo = false){
        if($codigo){
            
        /**
         * Al recibir el código a través de la URL 
         * es necesario filtrarlo a Entero para cambiarlo
         * de Cadena a Entero.
         */
            $codigo = $this->filtrarInt($codigo);
        } else {
            /*
             * Si no tenemos un código válido se da el error por defecto.
             */
            $codigo = 'default';
        }
        
        $error['default'] = 'Ha ocurrido un error y la página no puede mostrarse.';
        $error['5050'] = 'Acceso restringido';
        $error['8080'] = 'Tiempo de sesión agotado';
        
        /*
         * También hay que asegurarse que exista el código de error.
         */
        if(array_key_exists($codigo, $error)){
            return $error[$codigo];
        } else {
            return $error['default'];
        }
    }
    
    /**
     * Método para acceder a los métodos del controlador.
     */
    public function access($codigo){
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = $this->_getError($codigo);
        $this->_view->renderizar('access');
    }
    
}

?>
