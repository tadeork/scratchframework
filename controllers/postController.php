<?php

class postController extends Controller{
    /**
     * Con este atributo se va a instanciar 
     * el modelo para utilizarlo en todo el controlador.
     * @var type 
     */
    private $_post;
    public function __construct() {
        parent::__construct();
        $this->_post = $this->loadModel('post');
    }
     
    public function index(){
        $this->_view->posts = $this->_post->getPosts();
        
        $this->_view->titulo = 'Entradas';
        $this->_view->renderizar('index', 'post');
    }
}

?>
