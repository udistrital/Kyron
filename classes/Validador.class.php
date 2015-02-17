<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

class Validador {

    function __construct() {
        ;
    }

    /**
     * Función que valida si una cadena de caracteres contiene solo números
     * @param type $valor
     * @return boolean
     */
    function soloNumeros($valor) {
        if (is_numeric($valor)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Valida si una cadena de caracteres contiene estrictamente letras del alfabeto en mayúscula o minúscula
     * @param type $valor
     * @return boolean
     */
    function soloLetras($valor) {
        if (ctype_alpha($valor)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Valida si una cadena de caracteres contiene estrictamente letras del alfabeto en mayúscula o minúscula
     * @param type $valor
     * @return boolean
     */
    function soloLetrasEspacio($valor) {
        
        $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ";
        
        for ($i = 0; $i < strlen($valor); $i++) {
            if (strpos($permitidos, substr($valor, $i, 1)) === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Función que valida si una cadena de caracteres para correo está en formato válido
     * @param type $email
     * @return boolean
     */
    function validarCorreo($email) {
        //Verificar que solo existe una @y que los tamannos de las secciones son correctos segun la RFC 2822
        //if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) { //esto es como estaba antes
        if (!preg_match("^[^@]{1,64}@[^@]{1,255}$", $email)) {
            return false;
        }

        // Dividir el correo en secciones para analizarlas
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);

        for ($i = 0; $i < sizeof($local_array); $i++) {
            if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
                return false;
            }
        }

        if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
            // Verificar si hay una direccion IP en el dominio
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false;
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 
     * @param type $valor
     * @return boolean
     */
    function soloNumerosLetras($valor) {
        //compruebo que los caracteres sean los permitidos
        $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for ($i = 0; $i < strlen($valor); $i++) {
            if (strpos($permitidos, substr($valor, $i, 1)) === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Valida si la longitud de una cadena de caracteres se encuentra en el rango de valores estipulados
     * @param type $valor
     * @param type $lonMax
     * @param type $lonMin
     * @return boolean
     */
    function validaLongitud($valor, $lonMax, $lonMin) {

        if (strlen($valor) >= $lonMin && strlen($valor) <= $lonMax) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Eliminar caracteres especiales de las vocales
     * @param type $string
     * @return type
     */
    function eliminarTildes($string) {
        $string = str_replace(
                array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string
        );

        $string = str_replace(
                array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string
        );

        $string = str_replace(
                array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string
        );

        $string = str_replace(
                array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string
        );

        $string = str_replace(
                array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string
        );

        $string = str_replace(
                array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string
        );

        return $string;
    }

    /**
     * Valida si existen caracteres especiales en la cadena
     * @param type $valor
     * @return boolean
     */
    function validarCaracteresEspeciales($valor) {

        $caracteres = array("\\", "¨", "º", "-", "~",
            "#", "@", "|", "!", "\"",
            "·", "$", "%", "&", "/",
            "(", ")", "?", "'", "¡",
            "¿", "[", "^", "`", "]",
            "+", "}", "{", "¨", "´",
            ">", "<", ";", ",", ":",
            ".");

        if (in_array($valor, $caracteres)) {
            return true;
        }else{
            return false;
        }

    }

    /**
     * Elimina caracteres especiales de una cadena
     * @param type $string
     * @return type
     */
    function eliminarCaracteresEspeciales($string) {
        $string = trim($string);

        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
                array("\\", "¨", "º", "-", "~",
            "#", "|", "!", "\"",
            "·", "$", "%", "&", "/",
            "(", ")", "?", "'", "¡",
            "¿", "[", "^", "`", "]",
            "+", "}", "{", "¨", "´",
            ">", "<", ";", ",", ":"), '', $string
        );

        return $string;
    }
    
    /**
     * Valida si el número telefonico es valido
     * @param type $valor
     * @return boolean
     */
    function validarTelefonoFijo($valor){
        
        if($this->soloNumeros($valor)){
            if($this->validaLongitud($valor, 7, 7)){
                return true;
            }else{
                return false;
            }            
        }else{
            return false;
        }
        
    }
    
    /**
     * Valida si el número celular es válido
     * @param type $valor
     * @return boolean
     */
    function validarTelefonoCelular($valor){
        
        if($this->soloNumeros($valor)){
            if($this->validaLongitud($valor, 10, 10)){
                return true;
            }else{
                return false;
            }            
        }else{
            return false;
        }
    }
    
    /**
     * Valida si una fecha se encuentra en el formato deseado
     * @param type $valor
     * @param type $format
     * @return type
     */
    function validarFecha($valor, $format=""){
        $separator_type= array(
            "/",
            "-",
            "."
        );
        foreach ($separator_type as $separator) {
            $find= stripos($valor,$separator);
            if($find<>false){
                $separator_used= $separator;
            }
        }
        $input_array= explode($separator_used,$valor);
        if ($format=="mdy") {
            return checkdate($input_array[0],$input_array[1],$input_array[2]);
        } elseif ($format=="ymd") {
            return checkdate($input_array[1],$input_array[2],$input_array[0]);
        } else {
            return checkdate($input_array[1],$input_array[0],$input_array[2]);
        }
        $input_array=array();
    }
    
    

}

?>
