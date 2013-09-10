<?php

class postModel extends Model {

    /**
     * Construye desde el método del padre.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Pide todos los post.
     * @return type
     */
    public function getPosts() {
        $post = $this->_db->query('select * from posts');
        return $post->fetchall();
    }
    
    /**
     * Devuelve un sólo.
     * @param type $id
     */
    public function getPost($id){
        /**
         * Parsea el id, para asegurarnos de que 
         * está llegando un valor entero
         */
        $id = (int) $id;
        
        $post = $this->_db->query("select * from posts where =".$id);
        return $post->fetch();
    }
    
    /**
     * Método encargado de guardar las nuevas entradas.
     * @param type $titulo
     * @param type $cuerpo
     */
    public function insertarPost($titulo, $cuerpo) {
        /**
         * El método prepare elimina las comillas para evitar SQLInyection.
         */
        $this->_db->prepare("INSERT INTO posts VALUES (null, '".$titulo."', '".$cuerpo."')")
                ->execute();
    }

}

?>
