<?php
use core\general\ValidadorCampos;
class InspectorHTML {

	private static $instance;

	// Constructor
	function __construct() {

	}

	public static function singleton() {

		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className();
		}
		return self::$instance;

	}

	function limpiarPHPHTML($arreglo, $excluir = "") {

		if ($excluir != "") {
			$variables = explode("|", $excluir);
		} else {
			$variables[0] = "";
		}

		foreach ($arreglo as $clave => $valor) {
			if (!in_array($clave, $variables)) {

				$arreglo[$clave] = strip_tags($valor);
			}
		}

		return $arreglo;

	}

	function limpiarSQL($arreglo, $excluir = "") {

		if ($excluir != "") {
			$variables = explode("|", $excluir);
		} else {
			$variables[0] = "";
		}

		foreach ($arreglo as $clave => $valor) {
			if (!in_array($clave, $variables)) {

				$arreglo[$clave] = addcslashes($valor, '%_');
			}
		}

		return $arreglo;

	}

	/*
	 * Permite validar un campo con un arreglo de parámetros al estilo jquery-validation-engine
	 */
	function validarCampo($valorCampo, $parametros, $corregir=false) {
		
		if (isset($parametros['required'])) {
			$campoVacio = ($valorCampo == '') ? false : true;
			if (!$campoVacio) {
				return false;
			}
		}

		if (isset($parametros['minSize'])) {
			$tamannoCampo = strlen($valorCampo);
			if ($tamannoCampo<$parametros['minSize']) {
				if(!$corregir){
					return false;
				}
				$faltante = $parametros['minSize'] - $tamannoCampo;
				$faltante = str_repeat('',$faltante);
				$valorCampo .= $faltante; 
			}
		}
		
		if (isset($parametros['maxSize'])) {
			$tamannoCampo = strlen($valorCampo);
			if ($tamannoCampo>$parametros['maxSize']) {
				if(!$corregir){
					return false;
				}
				$sobrante = $parametros['minSize'] - $tamannoCampo;
				$valorCampo = substr($valorCampo, 0, $faltante);
			}
		}
		
		if (isset($parametros['custom'])) {
			include_once ('core/general/ValidadorCampos.class.php');
			$miValidador = new ValidadorCampos();
			$valido = $miValidador->validarTipo($valorCampo,$parametros['custom']);
			if (!$valido) {
				return false;
			}
		}
		
		/*
		 * Como se supone que ya superó la barrera de inyeccion SQl en la funcion limpiarSQL.
		 * Se quitan ', y " para que pueda ejecutarse el SQL. No se hace un tipo de corrección
		 * de ' (simple quote) con '' (doble simple quotes) para evitar los casos de inyección
		 * SQL y no fomentar la inserción de carácteres raros en nombres de funciones. 
		 */
	    /*
		 * "'" - simple 
		 * "\0" - NULL
	     * "\t" - tab
	     * "\n" - new line
	     * "\x0B" - vertical tab
	     * "\r" - carriage return
	     * " " - ordinary white space
		 * "\x00" - NULL
		 * "\x1a" - EOF
		 */
		$valorCampo = trim($valorCampo);var_dump($valorCampo);
		$valorCampo = str_replace(array('\'','"'), ' " ', $valorCampo);
		
		return $valorCampo;
	}

	/*
	 * Permite que los valores de $_REQUEST se validen del lado del servidor con el módulo
	 * ValidadorCampos de los componentes generales del CORE de SARA
	 */
	function validacionCampos($variables, $validadorCampos, $corregir=false) {

		function get_string_between($string, $start, $end) {
			$string = " " . $string;
			$ini = strpos($string, $start);
			if ($ini == 0)
				return "";
			$ini += strlen($start);
			$len = strpos($string, $end, $ini) - $ini;
			return substr($string, $ini, $len);
		}

		function get_string_before_char($string, $char) {
			$str = strstr($string, $char, true);
			return ($str == '') ? $string : $str;
		}

		function erase_string_spaces($string) {
			return str_replace(' ', '', $string);
		}

		function separarParametros($texto = '') {
			$valores = explode(",", $texto);
			$parametros = array();
			foreach ($valores as $valor) {
				$clave = erase_string_spaces(get_string_before_char($valor, "["));
				$valor = erase_string_spaces(get_string_between($valor, "[", "]"));
				$parametros[$clave] = $valor;
			}
			return $parametros;
		}

		foreach ($validadorCampos as $nombreCampo => $validador) {
			if (isset($variables[$nombreCampo])) {
				$parametros = separarParametros($validador);
				$validez = $this -> validarCampo($variables[$nombreCampo], $parametros, $corregir);
				if ($validez===false) {
					return false;
				} 
				$variables[$nombreCampo] = $validez;
			}
		}
		
		return $variables;
	}

	/*
	 * Permite decodificar los campos de $_REQUEST que hayan sido enviados codificados
	 * con la funcion "codificarCampos" del las instancias FormularioHtml.class.php.
	 */
	function decodificarCampos($valor) {
		return unserialize(base64_decode($valor));
	}

}
