<?php
/**
 * Esta clase segmenta y gestiona las partes de una url.
 * Provee los valores de la petición.
 */
class Request{
    private $_controlador;
    private $_metodo;
    private $_argumentos;
    /**
     * Constructor de la clase Request
     */
    public function __construct() {
        if(isset($_GET['url'])){
            /**
             * filter_input toma el parámetro <i>url</i> vía GET
             * lo pasa por el filtro Sanitize y lo devuelve filtrado.
             */
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            /**
             * explode divide en arreglo lo que contiene la variable url
             * separando los elementos a partir del marcador /
             * Esto es porque una parte de la url se refiere al controlador, 
             * otra al método y por último a los argumentos.
             */
            $url = explode('/', $url);
            /**
             * array_filter elimina todos los elementos no válidos dentro de un 
             * arreglo, esto sería eliminando marcadores / fuera de lugar
             */
            $url = array_filter($url);
        
        /**
         * array_shift extrae el primer elemento de la url y lo devuelve
         * En el primer paso se obtiene de la url el controller, 
         * en el segundo ahora el primer elemento es el método
         * y en el tercero queda como primer elemento los argumentos.
         */
            $this->_controlador = strtolower(array_shift($url));
            $this->_metodo = strtolower(array_shift($url));
            $this->_argumentos = $url;
        }

        /**
         * Si no se solicita nada, se realiza un pedido por defecto
         * que cumple con las reglas del framework.
         */
        if(!$this->_controlador){
            $this->_controlador = DEFAULT_CONTROLLER;
        }
        if(!$this->_metodo){
            $this->_metodo = 'index';
        }
        if(!isset($this->_argumentos)){
            $this->_argumentos = array();
        }
    }
    
    public function getControlador(){
        return $this->_controlador;
    }
    
    public function getMetodo(){
        return $this->_metodo;
    }
    
    public function getArgs(){
        return $this->_argumentos;
    }
}
?>
