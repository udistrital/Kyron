<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
/**
 * Esta clase permite validar rangos de datos normales de un $_REQUEST
 */
class Rangos {
	/**
	 * El array de alias permite hacer alias de las funciones para mayor versatilidad.
	 * Para contectar con jquery.validationEngine se podría usar date como alias y el valor real
	 * para cargar la funcion es Fecha
	 */
	private static $arrayAlias;
	function __construct() {
		self::$arrayAlias = array (
				"boleano" => "Boleano",
				"entero" => "Entero",
				"doble" => "Doble",
				"porcentaje" => "Porcentaje",
				"fecha" => "Fecha",
				"stringFecha" => "StringFecha",
				"texto" => "Texto",
				"lista" => "Lista",
				"nulo" => "Nulo" 
		);
	}
	private function validarBoleano($valor, $rango = '') {
		$valor = ( bool ) $valor;
		return is_bool ( $valor );
	}
	private function validarEntero($valor = '', $rango = '', $restriccion = '') {
		if (count ( explode ( ",", $restriccion ) ) > 1) {
			$restriccionArray = explode ( ",", $restriccion );
			$val = ( integer ) $valor;
			if (in_array ( $val, $restriccionArray ))
				return false;
		} elseif (count ( explode ( "-", $restriccion ) ) > 1) {
			$restriccionArray = explode ( "-", $restriccion );
			$val = ( integer ) $valor;
			if ($val >= $restriccionArray [0] && $val <= $restriccionArray [1])
				return false;
		} else {
			$val = ( integer ) $valor;
			if ($val == $restriccion)
				return false;
		}
		
		if ($rango == '*')
			return true;
		$intervalo = explode ( ",", $rango );
		if (! $intervalo)
			return false;
		$minimo = ( integer ) $intervalo [0];
		$maximo = ( integer ) $intervalo [1];
		if ($valor < $minimo || $valor > $maximo)
			return false;
		return true;
	}
	private function validarDoble($valor = '', $rango = '', $restriccion = '') {
		if (count ( explode ( ",", $restriccion ) ) > 1) {
			
			$restriccionArray = explode ( ",", $restriccion );
			$val = ( double ) $valor;
			if (in_array ( $val, $restriccionArray ))
				return false;
		} elseif (count ( explode ( "-", $restriccion ) ) > 1) {
			$restriccionArray = explode ( "-", $restriccion );
			$val = ( double ) $valor;
			if ($val >= $restriccionArray [0] && $val <= $restriccionArray [1])
				return false;
		} else {
			
			$val = ( double ) $valor;
			if ($val == $restriccion)
				return false;
		}
		
		if ($rango == '*')
			return true;
		$intervalo = explode ( ",", $rango );
		if (! $intervalo)
			return false;
		
		$minimo = ( double ) $intervalo [0];
		if (strpos ( $intervalo [0], '.' ) !== false)
			$minimo = ( double ) $intervalo [0];
		$maximo = ( double ) $intervalo [1];
		if (strpos ( $intervalo [1], '.' ) !== false)
			$maximo = ( double ) $intervalo [1];
		
		if ($valor < $minimo || $valor > $maximo)
			return false;
		return true;
	}
	private function validarPorcentaje($valor = '', $rango = '', $restriccion = '') {
		$valor = $valor / 100;
		
		if (count ( explode ( ",", $restriccion ) ) > 1) {
			$restriccionArray = explode ( ",", $restriccion );
			$val = ( double ) $valor;
			if (in_array ( $val, $restriccionArray ))
				return false;
		} elseif (count ( explode ( "-", $restriccion ) ) > 1) {
			$restriccionArray = explode ( "-", $restriccion );
			$val = ( double ) $valor;
			if ($val >= $restriccionArray [0] && $val <= $restriccionArray [1])
				return false;
		} else {
			$val = ( double ) $valor;
			if ($val == $restriccion)
				return false;
		}
		
		if ($rango == '*')
			return true;
		$intervalo = explode ( ",", $rango );
		if (! $intervalo)
			return false;
		$minimo = $intervalo [0] / 100;
		$maximo = $intervalo [1] / 100;
		if ($valor < $minimo || $valor > $maximo)
			return false;
		return true;
	}
	private function validarFecha($valor, $rango) {
		// Formato
		// 'd/m/Y'
		// 30/01/2014
		//
		$d = \DateTime::createFromFormat ( 'd/m/Y', $valor );
		
		if (count ( explode ( ",", $restriccion ) ) > 1) {
			$restriccionArray = explode ( ",", $restriccion );
			$val = $valor;
			if (in_array ( $val, $restriccionArray ))
				return false;
		} elseif (count ( explode ( "-", $restriccion ) ) > 1) {
			$restriccionArray = explode ( "-", $restriccion );
			$val = ( double ) $valor;
			$minimo = \DateTime::createFromFormat ( 'd/m/Y', $restriccionArray [0] );
			$maximo = \DateTime::createFromFormat ( 'd/m/Y', $restriccionArray [1] );
			if ($d >= $minimo && $d <= $maximo)
				return false;
		} else {
			$val = ( double ) $valor;
			if ($val == $restriccion)
				return false;
		}
		
		if ($d && $rango == '*')
			return true;
		
		$intervalo = explode ( ",", $rango );
		if (! $intervalo)
			return false;
		$minimo = \DateTime::createFromFormat ( 'd/m/Y', $intervalo [0] );
		$maximo = \DateTime::createFromFormat ( 'd/m/Y', $intervalo [1] );
		if (! $d || $d < $minimo || $d > $maximo)
			return false;
		return true;
	}
	private function validarTexto($valor = '', $rango = '') {
		if (count ( explode ( ",", $restriccion ) ) > 1) {
			$restriccionArray = explode ( ",", $restriccion );
			$val = $valor;
			if ($val >= $restriccionArray [0] && $val <= $restriccionArray [1])
				return false;
		} else {
			$val = $valor;
			if ($val == $restriccion)
				return false;
		}
		
		if ($rango == '*')
			return true;
		return in_array ( $valor, explode ( ",", $rango ) );
	}
	private function validarLista($valor, $rango = '') {
		if (count ( explode ( ",", $restriccion ) ) > 1) {
			$restriccionArray = explode ( ",", $restriccion );
			$val = $valor;
			if ($val >= $restriccionArray [0] && $val <= $restriccionArray [1])
				return false;
		} else {
			$val = $valor;
			if ($val == $restriccion)
				return false;
		}
		
		if ($rango == '*')
			return true;
		foreach ( explode ( ",", $valor ) as $val ) {
			if (! in_array ( $val, explode ( ",", $rango ) ))
				return false;
		}
		return true;
	}
	private function validarNulo($valor = '', $rango = '') {
		$valor = null;
		return is_null ( $valor );
	}
	public static function getAlias($tipo = "") {
		$arrayAlias = self::$arrayAlias;
		if (isset ( $arrayAlias [$tipo] )) {
			return $arrayAlias [$tipo];
		}
		return $tipo;
	}
	public static function validarRango($valor = "", $tipo = "", $rango = "", $restriccion = "") {
		$metodo = "validar" . strtoupper ( self::getAlias ( $tipo ) );
		if (method_exists ( get_class (), $metodo )) {
			return call_user_func_array ( array (
					get_class (),
					$metodo 
			), array (
					$valor,
					$rango,
					$restriccion 
			) );
		}
		return false;
	}
}

?>
