<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Tipos {
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
	private function validarBoleano($valor) {
		$valor = ( bool ) $valor;
		return is_bool ( $valor );
	}
	private function evaluarBoleano($valor) {
		$valor = ( bool ) $valor;
		return $valor;
	}
	private function validarEntero($valor) {
		$valor = ( int ) $valor;
		return is_int ( $valor );
	}
	private function evaluarEntero($valor) {
		$valor = ( int ) $valor;
		return is_int ( $valor ) ? $valor : false;
	}
	private function validarDoble($valor) {
		$valor = ( float ) $valor;
		return is_float ( $valor );
	}
	private function evaluarDoble($valor) {
		$valor = ( float ) $valor;
		return is_float ( $valor ) ? $valor : false;
	}
	private function validarPorcentaje($valor) {
		$valor = ( float ) $valor;
		return is_float ( $valor );
	}
	private function evaluarPorcentaje($valor) {
		$valor = ( float ) $valor;
		return is_float ( $valor ) ? $valor / 100 : false;
	}
	private function validarFecha($valor) {
		// Formato
		// 'd/m/Y'
		// 30/01/2014
		//
		$d = \DateTime::createFromFormat ( 'd/m/Y', $valor );
		return $d && $d->format ( 'd/m/Y' ) == $valor;
	}
	private function evaluarFecha($valor) {
		// Formato
		// 'd/m/Y'
		// 30/01/2014
		//
		$d = \DateTime::createFromFormat ( 'd/m/Y', $valor );
		return $d && $d->format ( 'd/m/Y' ) == $valor ? $d : false;
	}
	private function validarTexto($valor) {
		return is_string ( $valor );
	}
	private function evaluarTexto($valor) {
		return is_string ( $valor ) ? ( string ) $valor : false;
	}
	private function validarLista($valor) {
		return is_array ( explode ( ",", $valor ) );
	}
	private function evaluarLista($valor) {
		return is_array ( explode ( ",", $valor ) ) ? $valor : false;
	}
	private function validarNulo($valor) {
		$valor = null;
		return is_null ( $valor );
	}
	private function evaluarNulo($valor) {
		return null;
	}
	
	// http://www.sergiomejias.com/2007/09/validar-una-fecha-con-expresiones-regulares-en-php/
	public function validarStringFecha($fecha) {
		if (ereg ( "(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19|20)[0-9]{2}", $fecha )) {
			return true;
		} else {
			return false;
		}
	}
	public function evaluarStringFecha($fecha) {
		if (ereg ( "(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19|20)[0-9]{2}", $fecha )) {
			return $fecha;
		} else {
			return false;
		}
	}
	public static function getAlias($tipo = "") {
		$arrayAlias = self::$arrayAlias;
		if (isset ( $arrayAlias [$tipo] )) {
			return $arrayAlias [$tipo];
		}
		return $tipo;
	}
	public static function evaluarTipo($valor = "", $tipo = "") {
		$metodo = "evaluar" . strtoupper ( self::getAlias ( $tipo ) );
		if (method_exists ( get_class (), $metodo )) {
			return call_user_func_array ( array (
					get_class (),
					$metodo 
			), array (
					$valor 
			) );
		}
		return false;
	}
	public static function validarTipo($valor = "", $tipo = "") {
		$metodo = "validar" . strtoupper ( self::getAlias ( $tipo ) );
		if (method_exists ( get_class (), $metodo )) {
			return call_user_func_array ( array (
					get_class (),
					$metodo 
			), array (
					$valor 
			) );
		}
		return false;
	}
}

?>
