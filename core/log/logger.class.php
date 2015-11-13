<?php
require_once ("core/log/loggerSql.class.php");
require_once ("core/log/loggerBase.class.php");

class logger extends loggerBase {
	private static $instancia;
	const ACCEDER = 'acceso';
	const BUSCAR = 'busqueda';
	
	/**
	 *
	 * @name sesiones
	 *       constructor
	 */
	public function __construct() {
		$this->miSql = new loggerSql ();
		$this->miConfigurador = \Configurador::singleton ();
		$this->setPrefijoTablas ( $this->miConfigurador->getVariableConfiguracion ( "prefijo" ) );
		$this->setConexion ( $this->miConfigurador->fabricaConexiones->getRecursoDB ( "estructura" ) );
	}
	public static function singleton() {
		if (! isset ( self::$instancia )) {
			$className = __CLASS__;
			self::$instancia = new $className ();
		}
		return self::$instancia;
	}
	
	/**
	 *
	 * @name sesiones registra en la tabla de log de usuarios
	 * @param
	 *        	string nombre_db
	 * @return void
	 * @access public
	 */
	function log_usuario($log) {
		
		$log ['usuario'] = $_COOKIE['PHPSESSID'];
		$log ['accion'] = $_REQUEST['opcion'];
		$log ['fecha_log'] = date ( "F j, Y, g:i:s a" );
		$log ['host'] = $this->obtenerIP ();
		$log ['name_machine'] = php_uname();
		$log ['os'] = PHP_OS;
		$log ['datos'] = "";
		
		foreach (array_keys($log) as $llaves){
			if($llaves != "tiempo" && $llaves != "campoSeguro" && $llaves != "validadorCampos" && $llaves != "action" && $llaves != "option" && $llaves != "arreglo"){
				$log ['datos'] .= $llaves.":".$log[$llaves]." ";
			}
		}
		
		
		
		$cadenaSql = $this->miSql->getCadenaSql ( "registroLogUsuario", $log );
		$resultado = $this->miConexion->ejecutarAcceso ( $cadenaSql, self::ACCEDER, '', 'registroLogUsuario' );
	}
	function obtenerIP() {
		if (! empty ( $_SERVER ['HTTP_CLIENT_IP'] ))
			return $_SERVER ['HTTP_CLIENT_IP'];
		
		if (! empty ( $_SERVER ['HTTP_X_FORWARDED_FOR'] ))
			return $_SERVER ['HTTP_X_FORWARDED_FOR'];
		
		return $_SERVER ['REMOTE_ADDR'];
	}
}

?>
