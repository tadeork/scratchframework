<?php

class View {

    private $_controlador;
    private $_js;

    public function __construct(Request $peticion) {
        $this->_controlador = $peticion->getControlador();
        $this->_js = array();
    }

    public function renderizar($vista, $item = FALSE) {
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
                'id' => 'post',
                'titulo' => 'Entradas',
                'enlace' => BASE_URL . 'post'
            )
        );
        
        if(Session::get('autenticado')){
            /*
             * Si el usuario está autenticado muestra 
             * en el menú la opción de terminar la sesión.
             */
            $menu[] = array(
                'id' => 'login',
                'titulo' => 'Cerrar Sesion',
                'enlace' => BASE_URL . 'login/cerrar'
            );
        } else {
            /*
             * Sino lo está muestra en el menú el login.
             */
            $menu[] = array(
                'id' => 'login',
                'titulo' => 'Iniciar Sesion',
                'enlace' => BASE_URL . 'login'
            );
        }
        
        /*
         * Puede haber más de un archivo JS para cargar.
         */
        $js = array();

        if (count($this->_js)) {
            $js = $this->_js;
        }
        /**
         * Se le van a enviar las rutas al header y al footer de los archivos 
         * necesarios para mostrar el contenido con css, js e img.
         */
        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'menu' => $menu,
            'js' => $js
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
        if (is_readable($rutaView)) {
            /**
             * El header y el footer se incluyen a partir de la ruta básica
             * y se muestran con el orden dado a continuación.
             */
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
        } else {
            throw new Exception('Error de vista');
        }
    }

    /**
     * Con este método envíamos en un arreglo
     * los archivos JavaScript que deseemos incluir en una vista.
     * @param array $js
     */
    public function setJs(array $js) {
        if (is_array($js) && count($js)) {
            for ($i = 0; $i < count($js); $i++) {
                /**
                 * Dentro del arreglo privado _js se construye la ruta de acceso a los 
                 * archivos JavaScript relativos al controlador que ha solicitado 
                 * construir la vista. 
                 * Por ejemplo, el controlador post solicita que se construya la vista 
                 * para envíar al navegador, la ruta relativa de post es views/'nombre del controlador'/js/'nombre del archivo js'
                 * si como parámetro recibe más de un nombre, recorre el arreglo construyendo cada acceso al archivo solicitado.
                 */
                $this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i] . '.js';
            }
        } else {
            throw new Exception('Error de JS');
        }
    }

}

?>
