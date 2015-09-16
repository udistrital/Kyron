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
	 * Permite que los valores de $_REQUEST se validen del lado del servidor con el módulo
	 * ValidadorCampos de los componentes generales del CORE de SARA
	 */
	function validacionCampos($variables, $validadorCampos) {
		include ('core/general/ValidadorCampos.class.php');
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
			$string = explode($char, $string);
			return str_replace(' ','',$string[0]);
		}

		function separarParametros($texto = '') {
			$valores = explode(",", $texto);
			$parametros = array();
			foreach ($valores as $valor) {
				$clave = get_string_before_char($valor,"[");
				$valor = get_string_between($valor,"[","]");
				$parametros[$clave] = $valor;
			}
			return $parametros;
		}

		var_dump($variables, $validadorCampos);
		foreach ($validadorCampos as $campo => $validador) {
			if (isset($variables[$campo])) {
				$parametros = separarParametros($validador);
				var_dump($campo, $parametros);
			}
		}

		$miValidador = new ValidadorCampos();
		var_dump($miValidador -> evaluarTipo('10/02/2013', "fecha"));
	}

	/*
	 * Permite decodificar los campos de $_REQUEST que hayan sido enviados codificados
	 * con la funcion "codificarCampos" del las instancias FormularioHtml.class.php.
	 */
	function decodificarCampos($valor) {
		return unserialize(base64_decode($valor));
	}

}
