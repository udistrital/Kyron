<?php
require_once ("core/log/loggerSql.class.php");
require_once ("core/log/loggerBase.class.php");

class logger extends loggerBase {
	private static $instancia;
	const ACCEDER = 'acceso';
	const BUSCAR = 'busqueda';
	var $sesionUsuario;
	
	/**
	 *
	 * @name sesiones
	 *       constructor
	 */
	public function __construct() {
		$this->miSql = new loggerSql ();
		$this->miConfigurador = \Configurador::singleton ();
		$this->sesionUsuario = \Sesion::singleton ();
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
	function log_usuario($log, $cadenaSQL="") {
// 		if(isset($log['opcion']) && (/*$log['opcion']=="buscar" ||*/ $log['opcion']=="insertar" || $log['opcion']=="actualizar")){
			if(strcmp($log['opcion'], "buscar")==0){
				$log['opcion']= "CONSULTAR";
			}
			if(strcmp($log['opcion'], "insertar")==0){
				$log['opcion']= "REGISTRAR";
			}
			if(strcmp($log['opcion'], "actualizar")==0){
				$log['opcion']= "MODIFICAR";
			}
			$json = [];
			$json ['request'] = $log;
			$json ['cadenaSQLBase64'] = base64_encode($cadenaSQL);
			$json ['host'] = $this->obtenerIP ();
			$json ['machine'] = php_uname();
			$json ['server'] = $_SERVER;
			$json ['expiracionSesion'] = $this->sesionUsuario->getSesionExpiracion();
			$registroLog ['usuario'] = $this->sesionUsuario->getSesionUsuarioId();
			if ($registroLog['usuario'] == '' || $registroLog == null){
				$registroLog ['usuario'] = $log ['usuario'];
			}
			$registroLog ['accion'] = $log['opcion'];
			$registroLog ['fecha_log'] = date ( "F j, Y, g:i:s a" );
			$registroLog ['datos'] = array();
			foreach (array_keys($json) as $llaves){
				$registroLog ['datos'][$llaves]=$json[$llaves];
			}
			$registroLog ['datos'] = pg_escape_literal(json_encode($registroLog ['datos']));// only for postgres?
			
			$cadenaSql = $this->miSql->getCadenaSql ( "registroLogUsuario", $registroLog );
			$resultado = $this->miConexion->ejecutarAcceso ( $cadenaSql, self::ACCEDER);
			if (!$resultado){
				die('Error general del log');
			}
// 		}
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
