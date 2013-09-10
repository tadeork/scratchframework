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
        
        $post = $this->_db->query("SELECT * FROM posts WHERE id=".$id);
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
    
    /**
     * Método para actualizar los datos de un post.
     * @param type $id
     * @param type $titulo
     * @param type $cuerpo
     */
    public function editarPost($id, $titulo, $cuerpo){
        $id = (int) $id;
        /**
         * Se actualizan los campos titulo y cuerpo.
         */
        $this->_db->prepare("UPDATE posts SET titulo = :titulo, cuerpo = :cuerpo WHERE id = :id")
                ->execute(
                        array(
                           ':id' => $id,
                           ':titulo' => $titulo,
                           ':cuerpo' => $cuerpo
                        ));
    }
    
    public function eliminarPost($id){
        $id = (int) $id;
        $post = $this->_db->query("DELETE FROM posts WHERE id= $id");
    }

}

?>
