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
    
    /**
     * En este método se va a tomar la variable por POST
     * y la va a filtrar sanitizando y la devuelve limpia.
     * @param type $clave
     */
    protected function getTexto($clave){
        /**
         * Nos aseguramos de que venga contenido por el método POST.
         */
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            /**
             * Quita las comillas simples y dobles.
             */
            $_POST[$clave] = htmlspecialchars($_POST[$clave], ENT_QUOTES);
            return $_POST[$clave];
        }
        return '';
    }
    
    /**
     * En este método se va a tomar la variable por POST
     * y la va a filtrar sanitizando y la devuelve limpia.
     * @param type $clave
     * @return int
     */
    protected function getInt($clave){
        /**
         * Nos aseguramos de que venga contenido por el método POST.
         */
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            /**
             * Limpia y límita los datos numéricos.
             */
            $_POST[$clave] = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT);
            return $_POST[$clave];
        }
        return 0;
    }
    
    /**
     * Cuando se realiza una acción o se quiere cambiar de controlador
     * de vista se debe re direccionar desde el Controlador principal.
     * header es un método de PHP para enviar URL de HTTP en el navegador.
     * @param type $ruta
     */
    protected function redireccionar($ruta = false)
    {
        if($ruta){
            header('location:' . BASE_URL . $ruta);
            exit;
        }
        else{
            header('location:' . BASE_URL);
            exit;
        }
    }
    
    /**
     * Con este método nos aseguramos de tener con el formato correcto
     * el valor que recibimos por GET.
     * @param type $int
     * @return int
     */
    protected function filtrarInt($int){
        /**
         * Al venir el valor por GET es obligatorio parsear
         * porque está llegando como string.
         */
        $int = (int) $int;
        
        if(is_int($int)){
            return $int;
        } else {
            return 0;
        }
    }
    
    /**
     * Devuelve el parámetro POST sin filtrar, 
     * esto lo utiliza para que cuando se hagan cambios
     * en la base de datos y se realicen a través de la función
     * prepare de PDO no se guarden los caracteres especiales de html.
     * @param type $clave
     * @return type
     */
    protected function getPostParam($clave)
    {
        if(isset($_POST[$clave])){
            return $_POST[$clave];
        }
    }
    
    /**
     * Limpia los strings para evitar las sql-inyections.
     * @param type $clave
     * @return type
     */
    protected function getSql($clave){
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            if(!get_magic_quotes_gpc()){
                /*
                 * Elimina caracteres especiales en el string dado por unescaped_string, 
                 * teniendo en cuenta el conjunto de caracteres en uso de la conexión, 
                 * para que sea seguro usarla en mysql_query(). Si se van a insertar datos binarios, 
                 * se ha de usar esta función. 
                 * mysql_real_escape_string() llama a la función mysql_real_escape_string de la biblioteca de MySQL, 
                 * la cual antepone barras invertidas a los siguientes caracteres: \x00, \n, \r, \, ', " y \x1a. 
                 * Esta función siempre debe usarse (con pocas excepciones) para hacer seguros los datos 
                 * antes de enviar una consulta a MySQL
                 */
                $_POST[$clave] = mysql_escape_string($_POST[$clave]);
            }
            return trim($_POST[$clave]);
        }
    }
    
    /**
     * Reemplaza a todos los caracteres que sean diferentes a la cadena de parseo dada.
     * Esto es para evitar caracteres de escape.
     * @param type $clave
     * @return type
     */
    protected function getAlphaNum($clave){
        if(isset($_POST[$clave]) && preg_replace('/[^A-Z0-9_]/i','',$_POST[$clave])){
            return trim($_POST[$clave]);
        }
    }
}
?>
