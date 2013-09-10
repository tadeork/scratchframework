<?php

class indexController extends Controller{
    /**
     * Aquí tendremos disponible el acceso a la 
     * clase padre para llegar a las Views.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Cuando se solicita la vista Index se renderiza a través
     * del siguiente método.
     */
    public function index(){
        /**
         * Esta es la forma de cargar las vistas en la vista Index.
         */
        $post = $this->loadModel('post');
        
        $this->_view->posts = $post->getPosts();
        $this->_view->titulo = 'Portada';
        $this->_view->renderizar('index', 'inicio');
    }
}
?>
