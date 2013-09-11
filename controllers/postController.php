<?php

class postController extends Controller {

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

    public function index() {
        $this->_view->posts = $this->_post->getPosts();
        $this->_view->titulo = 'Entradas';
        $this->_view->renderizar('index', 'post');
    }

    /**
     * Método controlador para crear nuevas entradas.
     * En este método se hacen las llamadas al controlador
     * para validar los datos que vienen desde la vista, es 
     * decir desde el formulario.
     */
    public function nuevo() {
        Session::accesoEstricto(array('usuario'));
        
        $this->_view->titulo = 'Nueva Entrada';
        $this->_view->setJs(array('nuevo'));

        if ($this->getInt('guardar') == 1) {
            /**
             * En caso de que hayan datos válidos los obtenemos desde 
             * el formulario en el método POST y los retornamos para
             * que el usuario no deba re ingresarlos.
             */
            $this->_view->datos = $_POST;
            /**
             * Se valida que haya contenido en el título.
             */
            if (!$this->getTexto('titulo')) {
                $this->_view->_error = 'Debe llevar un título';
                $this->_view->renderizar('nuevo', 'post');
                exit();
            }
            /**
             * Se valida que haya contenido en el textarea.
             */
            if (!$this->getTexto('cuerpo')) {
                $this->_view->_error = 'Debe introducir texto.';
                $this->_view->renderizar('nuevo', 'post');
                exit();
            }

            /**
             * Si los datos son correctos se guarda la nueva entrada. 
             */
            $this->_post->insertarPost(
                    $this->getPostParam('titulo'), 
                    $this->getPostParam('cuerpo')
            );
            /**
             * Redirecciona al controlador post.
             */
            $this->redireccionar('post');
        }

        $this->_view->renderizar('nuevo', 'post');
    }

    /**
     * Método para editar un post.
     * @param type $id
     */
    public function editar($id) {
        /**
         * Si lo que tenemos en $id no es un entero 
         * se redirecciona a la página de post.
         */
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('post');
        }

        /**
         * Ahora se verifica que el registro solicitado 
         * exista. Sino redirige a la página post.
         */
        if (!$this->_post->getPost($this->filtrarInt($id))) {
            $this->redireccionar('post');
        }
        $this->_view->titulo = 'Editar Post';
        $this->_view->setJs(array('nuevo'));

        if ($this->getInt('guardar') == 1) {
            $this->_view->datos = $_POST;

            if (!$this->getTexto('titulo')) {
                $this->_view->_error = 'Debe llevar un título';
                $this->_view->renderizar('editar', 'post');
                exit();
            }

            if (!$this->getTexto('cuerpo')) {
                $this->_view->_error = 'Debe introducir texto.';
                $this->_view->renderizar('editar', 'post');
                exit();
            }

            $this->_post->editarPost(
                    $this->filtrarInt($id), 
                    $this->getPostParam('titulo'), 
                    $this->getPostParam('cuerpo')
                    );

            $this->redireccionar('post');
        }

        $this->_view->datos = $this->_post->getPost($this->filtrarInt($id));
        $this->_view->renderizar('editar', 'post');
    }
    
    /**
     * Para eliminar un post.
     * @param type $id
     */
    public function eliminar($id) {
        /**
         * Si id está vació redirecciona a la vista de 
         * post.
         */
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('post');
        }
        
        /**
         * Si id no devuelve un post existente redirecciona
         * a la vista post.
         */
        if (!$this->_post->getPost($this->filtrarInt($id))) {
            $this->redireccionar('post');
        }
        
        $this->_post->eliminarPost($this->filtrarInt($id));
        $this->redireccionar('post');

    }

}

?>
