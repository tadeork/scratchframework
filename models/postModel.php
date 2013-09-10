<?php

class postModel extends Model{
    /**
     * Construye desde el método del padre.
     */
    public function __construct() {
        parent::__construct();
    }
    
    public function getPosts(){
        $post = $this->_db->query('select * from posts');
        return $post->fetchall();
    }
}
?>
