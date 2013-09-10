<?php

class View{
    private $_controlador;
    
    public function __construct(Request $peticion) {
        $this->_controlador = $peticion->getControlador();
    }
    
    public function renderizar($vista, $item = FALSE){
        /**
         * El menú se envía de esta manera porque es común a todas las plantillas.
         */
        $menu = array(
            array(
                'id' => 'inicio',
                'titulo' => 'Inicio',
                'enlace' => BASE_URL
                ),
            array(
                'id' => 'hola',
                'titulo' => 'Hola',
                'enlace' => BASE_URL . 'hola'
                )
        );
        /**
         * Se le van a enviar las rutas al header y al footer de los archivos 
         * necesarios para mostrar el contenido con css, js e img.
         */
        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'menu' => $menu
        );
        
        /**
         * Construye la ruta de la vista que debe cargar
         * a partir de los controladores más el nombre
         * de la vista.
         */
        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';
        /**
         * Nos aseguramos de que exista y sea accesible.
         */
        if(is_readable($rutaView)){
            /**
             * El header y el footer se incluyen a partir de la ruta básica
             * y se muestran con el orden dado a continuación.
             */
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
        }else{
            throw new Exception('Error de vista');
        }
    }
}
?>
