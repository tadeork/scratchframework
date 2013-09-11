<?php
/**
 * Este objeto crea un nivel más de seguridad.
 */
class Hash {
    /**
     * Se espera que todos los controladores que lo necesiten lo puedan acceder.
     * @param type $algoritmo
     * @param type $data
     * @param type $key
     * @return type
     */
    public static function getHash($algoritmo, $data, $key){
        /*
         * Se configura el método hash.
         */
        $hash = hash_init($algoritmo, HASH_HMAC, $key);
        /*
         * Realiza la encriptación.
         */
        hash_update($hash, $data);
        /*
         * Devuelve la encriptación.
         */
        return hash_final($hash);
    }
}

?>
