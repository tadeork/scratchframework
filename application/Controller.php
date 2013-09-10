<?php
/**
 * De esta clase heredarán todos los controladores. 
 */
abstract class Controller{
    protected $_view;
    
    public function __construct() {
        /**
         * Con este constructor tenemos disponibel el objeto
         * view desde el controlador principal.
         */
        $this->_view = new View(new Request());
    }

    /**
     * Este método abstracto obliga a todas las clases 
     * que hereden de Controller que implementen un método index, 
     * aunque no tenga código.
     */
    abstract public function index();
    
    /**
     * Este método retorna una instancia del modelo.
     * Verifica que exista el modelo, si existe adquiere el modelo
     * lo instancia y devuelve la instancia del modelos.
     * @param type $modelo
     * @return \modelo
     * @throws Exception
     */
    protected function loadModel($modelo){
        $modelo = $modelo . 'Model';
        $rutaModelo = ROOT . 'models' . DS . $modelo . '.php';
        
        if(is_readable($rutaModelo)){
            require_once $rutaModelo;
            $modelo = new $modelo;
            return $modelo;
        } else {
            throw new Exception('Error de Modelo');
        }
    }
}
?>
