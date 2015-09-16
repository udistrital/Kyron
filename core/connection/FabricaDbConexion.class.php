<?php

/**
 * Fabrica de objetos para la familia de conexiones a bases de datos
 *
 * @author      Paulo Cesar Coronado
 * @version     2.0.0.0, 03/11/2012
 * @package     framework::BCK::db
 * @copyright   Universidad Distrital F.J.C
 * @license     GPL Version 3.0 o posterior
 *
 */
require_once ("Conector.interface.php");
require_once ("ConectorDb.php");
require_once ("Mysql.class.php");
require_once ("Oci8.class.php");
require_once ("Pgsql.class.php");
require_once ("Dbms.class.php");

require_once ("core/crypto/Encriptador.class.php");
require_once ("core/locale/Lenguaje.class.php");

class FabricaDbConexion {

	private $configuracion;

	public $crypto;

	private $misConexiones;

	public $miLenguaje;

	private static $instance;

	const CONFIGURACION = 'configuracion';

	public static function singleton() {

		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className();
		}
		return self::$instance;

	}

	private function __construct() {

		$this -> crypto = Encriptador::singleton();

		/**
		 * De forma predeterminadalos mensajes de error definidos en la clase
		 * se presentan en español
		 */
		$this -> miLenguaje = Lenguaje::singleton();
		$this -> misConexiones = array();

	}

	/**
	 * Método.
	 * Se encarga de crear un objeto para gestionar la conexión a un recurso
	 * de bases de datos dado. Los recursos pueden estar registrados en dos sitios:
	 * (a) en el archivo config.class.php, cuyos datos se gestionan por un objeto de
	 * la clase configurador (configuracion).
	 * (b) en la tabla dbms (tabla).
	 *
	 * De forma predeterminada se buscan los datos en la tabla.
	 *
	 * @param string $nombre
	 * @return boolean dbms
	 */
	public function setRecursoDB($nombre = "", $fuente = "tabla") {

		if ($nombre == "") {
			$nombre = self::CONFIGURACION;
		}

		switch ($fuente) {

			case self::CONFIGURACION :
			case "instalacion" :
				return $this -> recursoConfiguracion($nombre);
				break;

			default :
				return $this -> recursoTabla($nombre);
				break;
		}

	}

	/**
	 * Método.
	 * Encargado de crear los recursos de acceso a las bases de datos y
	 * agregarlos al arreglo de conexiones.
	 *
	 * @return boolean
	 */
	private function recursoConfiguracion($nombre, $registro = "") {

		if ($registro == '') {
			$gestorDb = new Dbms($this -> configuracion);

		} else {
			$gestorDb = new Dbms($registro);

		}
		$recurso = $gestorDb -> getRecursoDb();

		if ($recurso && !isset($this -> misConexiones[$nombre])) {
			$this -> misConexiones[$nombre] = $recurso;
			return true;
		}

		error_log($this -> miLenguaje -> getCadena("noInstanciaDatos"));
		return false;

	}

	private function recursoTabla($nombre) {

		$recursoDB = $this -> getRecursoDB(self::CONFIGURACION);
		$cadena = $this -> getClausulaSQL($nombre);

		$resultado = $recursoDB -> ejecutarAcceso($cadena, "busqueda");

		if (is_array($resultado)) {
			foreach ($resultado [0] as $clave => $valor) {
				$resultado[0][$clave] = trim($valor);
			}

			$resultado[0]["dbclave"] = $this -> crypto -> decodificar($resultado[0]["dbclave"]);
			$resultado[0][6] = $this -> crypto -> decodificar(trim($resultado[0][6]));
			return $this -> recursoConfiguracion($nombre, $resultado);
		}
		return false;

	}

	private function getClausulaSQL($variable) {

		if (isset($this -> configuracion["dbprefijo"])) {

			$cadenaSql = "SELECT ";
			$cadenaSql .= 'nombre,  
                           servidor as dbdns, 
                           puerto as dbpuerto, 
                           conexionssh as dbssl, 
                           db as dbnombre, 
                           esquema as dbesquema, 
                           usuario as dbusuario, 
                           password as dbclave, 
                           dbms as dbsys ';
			$cadenaSql .= "FROM ";
			$esquema = '';
			if ($this -> configuracion["dbesquema"] != '') {
				$esquema = $this -> configuracion["dbesquema"] . '.';
			}
			$cadenaSql .= $esquema . $this -> configuracion["dbprefijo"] . "dbms ";
			$cadenaSql .= "WHERE ";
			return $cadenaSql .= "nombre='" . $variable . "'";

		}

		return false;

	}

	/**
	 * Método de acceso.
	 *
	 * @param unknown $configuracion
	 */
	public function setConfiguracion($configuracion) {

		$this -> configuracion = $configuracion;
		return true;

	}

	/**
	 * Método de Acceso
	 *
	 * @param string $name
	 * @return NULL
	 */
	public function getRecursoDB($name) {

		if (isset($this -> misConexiones[$name])) {
			return $this -> misConexiones[$name];
		} else {

			// Trata de crear la conexiòn
			$this -> setRecursoDB($name, 'tabla');

			if (isset($this -> misConexiones[$name])) {
				return $this -> misConexiones[$name];
			}

			return false;
		}

	}

}
?>