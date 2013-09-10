<?php
/**
 * Recibe y procesa la petición.
 * Llama al controlador y luego al método que se lo está enviando.
 * Si no hay método ejecuta por defecto el index.
 */
class Bootstrap{
    public static function run(Request $peticion){
        $controller = $peticion->getControlador() .'Controller';
        $rutaControlador = ROOT . 'controllers' . DS . $controller . '.php';
        $metodo = $peticion->getMetodo();
        $args = $peticion->getArgs();
        
        /**
         * is_readable verifica si el archivo que está en la ruta 
         * existe y también válido o legible.
         */
        if(is_readable($rutaControlador)){
            require_once $rutaControlador;
            
            $controller = new $controller;
            /**
             * Si no devuelve un método válido llama 
             * al método index.
             */
            if(is_callable(array($controller, $metodo))){
                $metodo = $peticion->getMetodo();
            } else {
                $metodo = 'index';
            }
            /**
             * Verificamos los argumentos para llamar
             * al controlador.
             */
            if(isset($args)){
                /**
                 * En un arreglo enviámos el nombre de la clase que 
                 * necesitamos junto con el método y los argumentos.
                 */
                call_user_func_array(array($controller, $metodo), $args);
            } else {
                /**
                 * Si no hay argumentos, sólo llama a la clase
                 * y al método.
                 */
                call_user_func(array($controller, $metodo));
            }
        } else {
            throw new Exception('No existe');
        }
    }
}
?>
