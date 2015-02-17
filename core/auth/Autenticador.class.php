<?

/**
 * Autenticador.class.php
 *
 * Encargado de gestionar las sesiones de usuario.
 *
 * @author 	Paulo Cesar Coronado
 * @version 	1.1.0.1
 * @package 	Kixi
 * @copyright 	Universidad Distrital Francisco Jose de Caldas - Grupo de Trabajo Academico GNU/Linux GLUD
 * @license 	GPL Version 3 o posterior
 *
 */
class Autenticador {

	private static $instancia;

	/**
	 *
	 *
	 * Arreglo que contiene los datos de la página que se va revisar
	 * 
	 * @var String[]
	 */
	var $pagina;

	/**
	 * Objeto.
	 * Con los atributos y métodos para gestionar la sesión de usuario
	 * 
	 * @var Sesion
	 */
	var $sesionUsuario;

	var $tipoError;

	var $configurador;

	private function __construct() {

		$this->configurador = Configurador::singleton ();
		
		require_once ($this->configurador->getVariableConfiguracion ( "raizDocumento" ) . "/core/auth/Sesion.class.php");
		$this->sesionUsuario = Sesion::singleton ();
		$this->sesionUsuario->setSesionUsuario ( $this->configurador->fabricaConexiones->miLenguaje->getCadena ( "usuarioAnonimo" ) );
		$this->sesionUsuario->setConexion ( $this->configurador->fabricaConexiones->getRecursoDB ( "configuracion" ) );
		$this->sesionUsuario->setTiempoExpiracion ( $this->configurador->getVariableConfiguracion ( "expiracion" ) );
		$this->sesionUsuario->setPrefijoTablas($this->configurador->getVariableConfiguracion ( "prefijo" ));
	
	}

	public static function singleton() {

		if (! isset ( self::$instancia )) {
			$className = __CLASS__;
			self::$instancia = new $className ();
		}
		return self::$instancia;
	
	}

	function iniciarAutenticacion() {

		$resultado = $this->verificarExistenciaPagina ();
		if ($resultado) {
			$resultado = $this->cargarSesionUsuario ();
			
			if ($resultado) {
				// Verificar que el usuario está autorizado para el nivel de acceso de la página				
						
				$resultado = $this->verificarAutorizacionUsuario ();
				if ($resultado) {
					return true;
				}
				$this->tipoError = "usuarioNoAutorizado";
				return false;
			}
			$this->tipoError = "sesionNoExiste";
			return false;
		}
		
		$this->tipoError = "paginaNoExiste";
		return false;
	
	}

	function setPagina($pagina) {

		$this->pagina ["nombre"] = $pagina;
	
	}

	private function verificarExistenciaPagina() {

		$clausulaSQL = $this->sesionUsuario->miSql->getCadenaSql ( "seleccionarPagina", $this->pagina ["nombre"] );
		
		if ($clausulaSQL) {
			
			$registro = $this->configurador->conexionDB->ejecutarAcceso ( $clausulaSQL, "busqueda" );
			$totalRegistros = $this->configurador->conexionDB->getConteo ();
			
			if ($totalRegistros > 0) {
				$this->pagina ["nivel"] = $registro [0] [0];
				return true;
			}
		}
		$this->tipoError = "paginaNoExiste";
		return false;
	
	}

	function getError() {

		return $this->tipoError;
	
	}

	/**
	 * Método.
	 * 
	 * @return boolean
	 */
	function cargarSesionUsuario() {
		
		// Asignar el nivel de la sesión conforme al nivel de la página que se está visitando
		$this->sesionUsuario->setSesionNivel ( $this->pagina ["nivel"] );
		
		
		$verificar = $this->sesionUsuario->verificarSesion ();

		if ($verificar == false) {
			$this->tipoError = "sesionNoExiste";
			return false;
		}
		
		return true;
	
	}

	function verificarAutorizacionUsuario() {

		if ($this->sesionUsuario->getSesionNivel () == $this->pagina ["nivel"]) {
			return true;
		}
		
		return false;
	
	}

}
?>
