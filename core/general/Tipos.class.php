<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}


class Tipos {
	function __construct() {
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
		return $d && $d->format ( 'd/m/Y' ) == $valor ? $valor : false;
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
	public function validar_fecha($fecha) {
		if (ereg ( "(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19|20)[0-9]{2}", $fecha )) {
			return true;
		} else {
			return false;
		}
	}
	public static function evaluarTipo($valor = "", $tipo = "") {
		$arrayDatos = self::setAmbiente ( $tipo );
		
		if ($arrayDatos) {
			
			$idTipo = $arrayDatos ['id'];
			$nombreTipo = $arrayDatos ['nombre'];
			$aliasTipo = $arrayDatos ['alias'];
			$metodo = "evaluar" . strtoupper ( $aliasTipo );
			
			switch ($tipo) {
				case $idTipo :
					if (method_exists ( get_class (), $metodo ))
						return call_user_func_array ( array (
								get_class (),
								$metodo 
						), array (
								$valor 
						) );
					return false;
					break;
				default :
					return false;
					break;
			}
		}
		return false;
	}
	public static function getTipoAlias($tipo = "") {
		$arrayDatos = self::setAmbiente ( $tipo );
		
		if ($arrayDatos) {
			return $arrayDatos ['alias'];
		}
	}
	public static function getTipoNombre($tipo = "") {
		$arrayDatos = self::setAmbiente ( $tipo );
		
		if ($arrayDatos) {
			return $arrayDatos ['nombre'];
		}
	}
	public static function validarTipo($valor = "", $tipo = "") {
		$arrayDatos = self::setAmbiente ( $tipo );
		
		if ($arrayDatos) {
			
			$idTipo = $arrayDatos ['id'];
			$nombreTipo = $arrayDatos ['nombre'];
			$aliasTipo = $arrayDatos ['alias'];
			$metodo = "validar" . strtoupper ( $aliasTipo );
			;
			
			switch ($tipo) {
				case $idTipo :
					if (method_exists ( get_class (), $metodo ))
						return call_user_func_array ( array (
								get_class (),
								$metodo 
						), array (
								$valor 
						) );
					return false;
					break;
				default :
					return false;
					break;
			}
		}
		return false;
	}
}

?>
