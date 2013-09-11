<?php

class loginController extends Controller {
    private $_login;
    public function __construct() {
        parent::__construct();
        $this->_login = $this->loadModel('login');
    }

    /**
     * 
     */
    public function index() {
        $this->_view->titulo = 'Iniciar Sesión';
        
        if($this->getInt('enviar')==1){
            $this->_view->datos = $_POST;
            /*
             * En caso de que ocurra un error recupera los datos.
             */
            $this->datos = $_POST;
            /*
             * valida el nombre de usuario
             */
            if(!$this->getAlphaNum('usuario')){
                $this->_view->_error = 'Debe introducir su nombre de usuario';
                $this->_view->renderizar('index','login');
                exit();
            }
            /*
             * valida el password
             */
            if(!$this->getSql('pass')){
                $this->_view->_error = 'Debe introducir su password';
                $this->_view->renderizar('index','login');
                exit();
            }
            
            /*
             * Se consulta por el usuario en la BD.
             */
            $row = $this->_login->getUsuario(
                    $this->getAlphaNum('usuario'),
                    $this->getSql('pass')
                    );
            /*
             * Si no existe...
             */
            if(!$row){
                $this->_view->_error = 'Usuario y/o password incorrectos';
                $this->_view->renderizar('index','login');
                exit();
            }
            
            /*
             * El estado determina la situación del usuario.
             */
            if($row['estado'] != 1){
                $this->_view->_error = 'Este usuario no esta habilitado';
                $this->_view->renderizar('index','login');
                exit;
            }
            /*
             * Una vez superadas todas las validaciones puede darse el inicio de sesión.
             */
            Session::set('autenticado', true);
            Session::set('level', $row['role']);
            Session::set('usuario', $row['usuario']);
            Session::set('id_usuario', $row['id']);
            Session::set('tiempo', time());
               
            $this->redireccionar();
        }
            
        $this->_view->renderizar('index','login');

    }    
    
    /**
     * Cierra la sesión.
     */
    public function cerrar(){
        Session::destroy(array());
        $this->redireccionar('login/mostrar');
    }
}

?>
