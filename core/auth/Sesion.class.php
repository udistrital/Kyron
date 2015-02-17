<?php
require_once ("core/auth/sesionSql.class.php");

class Sesion {

	/**
	 * Aggregations:
	 */
	
	/**
	 * Compositions:
	 */
	
	/**
	 * * Attributes: **
	 */
	
	/**
	 * Miembros privados de la clase
	 *
	 * @access private
	 */
	private static $instancia;

	/**
	 * Atributos de la sesión
	 */
	var $sesionId;

	var $sesionExpiracion;

	var $sesionUsuarioId;

	var $registro_sesion;

	var $miSql;

	var $prefijoTablas;

	var $tiempoExpiracion;

	/**
	 *
	 * @name sesiones
	 *       constructor
	 */
	private function __construct() {

		$this->miSql = new sesionSql ();
		
		// Valores predefinidos para las sesiones
		$this->sesionUsuarioNombre = '';
		$this->sesionNivel = 0;
	
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
	 * @name sesiones Verifica la existencia de una sesion válida en la máquina del cliente
	 * @param
	 *        	string nombre_db
	 * @return void
	 * @access public
	 */
	function verificarSesion() {
		
		// Se eliminan las sesiones expiradas
		$borrar = $this->borrarSesionExpirada ();
		
		if ($this->sesionNivel > 0) {
			
			// Verificar si en el cliente existe y tenga registrada una cookie que identifique la sesion
			$this->sesionId = $this->numeroSesion ();
			
			if ($this->sesionId) {
				$resultado = $this->abrirSesion ( $this->sesionId );
				
				/* Detecta errores */
				if ($resultado == false) {
					
					return false;
				} else {
					
					// Si no hubo errores se puede actualizar los valores
					// Update, porque se tiene un identificador
					/* Crear una nueva cookie */
					
					$parametro ['expiracion'] = time () + 60 * $this->tiempoExpiracion;
					$parametro ['sesionId'] = $this->sesionId;
					
					setcookie ( "aplicativo", $this->sesionId, ($parametro ['expiracion']), "/" );
					
					$cadenaSql = $this->miSql->getCadenaSql ( "actualizarSesion", $parametro );
					
					/**
					 * Ejecutar una consulta
					 */
					
					$resultado = $this->miConexion->ejecutarAcceso ( $cadenaSql, "acceso" );
					
					return $resultado;
				}
			}
			
			return false;
		}
		return true;
	
	}

	/**
	 * @METHOD numero_sesion
	 *
	 * Rescata el número de sesion correspondiente a la máquina
	 * @PARAM sesion
	 *
	 * @return valor
	 * @access public
	 */
	function numeroSesion() {

		if (isset ( $_COOKIE ["aplicativo"] )) {
			$this->sesionId = $_COOKIE ["aplicativo"];
		} else {
			if (isset ( $_REQUEST ["sesionID"] )) {
				$this->sesionId = $_REQUEST ["sesionID"];
			} else {
				return false;
			}
		}
		
		return $this->sesionId;
	
	} /* Fin de la función numero_sesion */

	/**
	 * @METHOD abrir_sesion
	 *
	 * Busca la sesión en la base de datos
	 * @PARAM sesion
	 *
	 * @return valor
	 * @access public
	 */
	function abrirSesion($sesion) {
		// Primero se verifica la longitud del parámetro
		if (strlen ( $sesion ) != 32) {
			return FALSE;
		} else {
			// Verifica la validez del id de sesion
			
			if ($this->caracteresValidos ( $sesion ) != strlen ( $sesion )) {
				return false;
			}
			
			$this->setSesionId ( $sesion );
			
			// Busca una sesión que coincida con el id del computador y el nivel de acceso de la página
			$this->sesionUsuarioId = trim ( $this->getValorSesion ( 'idUsuario' ) );
			$nivelPagina = $this->getSesionNivel ();
			$nivelAut = false;
			
			if ($this->sesionUsuarioId) {
				
				$cadenaSql = $this->miSql->getCadenaSql ( "verificarNivelUsuario", $this->sesionUsuarioId );
				$resultadoNivel = $this->miConexion->ejecutarAcceso ( $cadenaSql, "busqueda" );
				
				/**
				 *
				 * @deprecated La siguiente comprobación no hace parte del core de SARA se utiliza para el
				 *             aplicativo de voto.
				 */
				if (! $resultadoNivel) {
					
					$cadenaSql = $this->miSql->getCadenaSql ( 'verificarUsuarioCenso', $this->sesionUsuarioId );
					$resultadoNivel = $this->miConexion->ejecutarAcceso ( $cadenaSql, 'busqueda' );
					if ($resultadoNivel && $nivelPagina == 1) {
						$nivelAut = true;
						
					}
				} else {
					
					$tipo = explode ( ",", $resultadoNivel [0] ['tipo'] );
					
					for($i = 0; $i < count ( $tipo ); $i ++) {
						if ($tipo [$i] == $nivelPagina) {
							$nivelAut = true;
						}
					}
				}
				
				if (($this->sesionExpiracion > time ()) && ($nivelAut == true)) {
					return true;
				}
			}
			
			return false;
		}
	
	} // Final del método abrir_sesion
	
	/**
	 * @METHOD caracteres_validos
	 *
	 * Verifica que los caracteres en el identificador de sesión sean válidos
	 * @PARAM cadena
	 *
	 * @return valor
	 * @access public//Realizar un barrido por la matriz de resultados para comprobar que se tiene los privilegios para la pagina
	 *         $this->validacion=0;
	 *         for($this->i=0;$this->i<$this->count;$this->i++)
	 *         {
	 */
	function caracteresValidos($cadena) {
		// Retorna el número de elementos que coinciden con la lista de caracteres
		return strspn ( $cadena, "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789" );
	
	}

	/**
	 * @METHOD crear_sesion
	 *
	 * Crea una nueva sesión en la base de datos.
	 * @PARAM usuario_aplicativo
	 * @PARAM nivel_acceso
	 * @PARAM expiracion
	 * @PARAM conexion_id
	 *
	 * @return boolean
	 * @access public
	 */
	function crearSesion($usuarioId) {
		
		// 0. Borrar todas las sesiones del equipo
		if ($this->verificarSesion ()) {
			
			$this->terminarSesion ( $this->sesionId );
		}
		
		// 1. Identificador de sesion
		$this->fecha = explode ( " ", microtime () );
		$this->sesionId = md5 ( $this->fecha [1] . substr ( $this->fecha [0], 2 ) . rand () );
		
		if (strlen ( $this->sesionId ) != 32) {
			return FALSE;
		} else {
			// Verifica la validez del id de sesion
			if ($this->caracteresValidos ( $this->sesionId ) != strlen ( $this->sesionId )) {
				return FALSE;
			}
			
			/**
			 * Borra todas las sesiones que existan con el id del computador
			 */
			
			if (isset ( $_COOKIE ["aplicativo"] )) {
				$this->la_sesion = $_COOKIE ["aplicativo"];
				$this->terminarSesion ( $this->la_sesion );
			}
			
			/* Actualizar la cookie, la sesión tiene un tiempo de 1 hora */
			
			$this->sesionExpiracion = time () + $this->tiempoExpiracion * 60;
			setcookie ( "aplicativo", $this->sesionId, $this->sesionExpiracion, "/" );
			
			// Insertar id_usuario
			$this->resultado = $this->guardarValorSesion ( 'idUsuario', $usuarioId, $this->sesionId, $this->sesionExpiracion );
			if ($this->resultado) {
				return $this->sesionId;
			} else {
				
				return false;
			}
		}
	
	} // Fin del método crear_sesion
	
	/**
	 * @METHOD guardar_valor_sesion
	 * @PARAM variable
	 * @PARAM valor
	 *
	 * @return boolean
	 * @access public
	 */
	function guardarValorSesion($variable, $valor, $sesion, $expiracion) {

		$num_args = func_num_args ();
		if ($num_args == 0) {
			return FALSE;
		} else {
			if (strlen ( $sesion ) != 32) {
				if (isset ( $_COOKIE ["aplicativo"] )) {
					$this->sesionId = $_COOKIE ["aplicativo"];
				} else {
					return FALSE;
				}
			} else {
				$this->sesionId = $sesion;
			}
			
			// Si el valor de sesión existe entonces se actualiza, si no se crea un registro con el valor.
			
			$parametro ["sesionId"] = $this->sesionId;
			$parametro ["variable"] = $variable;
			$parametro ["valor"] = $valor;
			$parametro ["expiracion"] = $expiracion;
			$cadenaSql = $this->miSql->getCadenaSql ( "buscarValorSesion", $parametro );
			
			$resultado = $this->miConexion->ejecutarAcceso ( $cadenaSql, "busqueda" );
			
			if ($resultado) {
				
				$cadenaSql = $this->miSql->getCadenaSql ( "actualizarValorSesion", $parametro );
			} else {
				$cadenaSql = $this->miSql->getCadenaSql ( "insertarValorSesion", $parametro );
			}
			
			$resultado = $this->miConexion->ejecutarAcceso ( $cadenaSql, "acceso" );
			return $resultado;
		}
	
	} // Fin del método guardar_valor_sesion
	function setValorSesion($variable, $valor) {

		$num_args = func_num_args ();
		if ($num_args == 0) {
			return FALSE;
		} else {
			
			// Si el valor de sesión existe entonces se actualiza, si no se crea un registro con el valor.
			
			$parametro ["sesionId"] = $this->sesionId;
			$parametro ["variable"] = $variable;
			$parametro ["valor"] = $valor;
			$parametro ["expiracion"] = $this->tiempoExpiracion;
			$cadenaSql = $this->miSql->getCadenaSql ( "buscarValorSesion", $parametro );
			
			$resultado = $this->miConexion->ejecutarAcceso ( $cadenaSql, "busqueda" );
			
			if ($resultado) {
				
				$cadenaSql = $this->miSql->getCadenaSql ( "actualizarValorSesion", $parametro );
			} else {
				$cadenaSql = $this->miSql->getCadenaSql ( "insertarValorSesion", $parametro );
			}
			
			$resultado = $this->miConexion->ejecutarAcceso ( $cadenaSql, "acceso" );
			return $resultado;
		}
	
	} // Fin del método guardar_valor_sesion
	
	/**
	 * @METHOD borrar_valor_sesion
	 * @PARAM variable
	 * @PARAM valor
	 *
	 * @return boolean
	 * @access public
	 */
	function borrarValorSesion($variable, $sesion = "") {

		if (strlen ( $sesion ) != 32) {
			if (isset ( $_COOKIE ["aplicativo"] )) {
				$sesion = $_COOKIE ["aplicativo"];
			} else {
				return false;
			}
		}
		
		$parametro ["sesionId"] = $sesion;
		$parametro ["dato"] = $variable;
		
		if ($variable != 'TODOS') {
			$cadenaSql = $this->miSql->getCadenaSql ( "borrarVariableSesion", $parametro );
		} else {
			$cadenaSql = $this->miSql->getCadenaSql ( "borrarSesion", $parametro );
		}
		
		if ($this->miConexion->ejecutarAcceso ( $cadenaSql )) {
			return false;
		} else {
			return true;
		}
	
	} // Fin del método borrar_valor_sesion
	
	/**
	 *
	 * @name borrar_sesion_expirada
	 * @return void
	 * @access public
	 */
	function borrarSesionExpirada() {

		$cadenaSql = $cadenaSql = $this->miSql->getCadenaSql ( "borrarSesionesExpiradas" );
		
		if ($this->miConexion->ejecutarAcceso ( $cadenaSql )) {
			return false;
		} else {
			return true;
		}
	
	} // Fin del método borrar_sesion_expirada
	
	/**
	 *
	 * @name terminar_sesion
	 * @return boolean
	 * @access public
	 */
	function terminarSesion($sesion) {

		if (strlen ( $sesion ) != 32) {
			return FALSE;
		}
		// Borrar cookies anteriores
		setcookie ( "aplicativo", "", time () - 3600, "/" );
		
		$cadenaSql = $cadenaSql = $this->miSql->getCadenaSql ( "borrarSesion", $sesion );
		
		if ($this->miConexion->ejecutarAcceso ( $cadenaSql )) {
			return false;
		} else {
			return true;
		}
	
	} // Fin del método terminar_sesion
	
	/**
	 * @METHOD setSesionId
	 *
	 * Asigna el valor del atributo sesionId
	 *
	 * @return valor
	 * @access public
	 */
	function setSesionId($sesionId) {

		$this->sesionId = $sesionId;
	
	} // end of member function especificar_sesion
	
	/**
	 * @METHOD setSesionExpiracion
	 *
	 * @return valor
	 * @access public
	 */
	function setSesionExpiracion($expiracion) {

		$this->sesionExpiracion = $expiracion;
	
	} // Fin del mètodo especificar_expiracion
	function setConexion($conexion) {

		$this->miConexion = $conexion;
	
	}

	/**
	 * @METHOD setSesionNivel
	 *
	 * @param
	 *        	nivel
	 * @access public
	 */
	function setSesionNivel($nivel) {

		$this->sesionNivel = $nivel;
	
	} // Fin de la función especificar_enlace
	
	/**
	 * @METHOD setIdusuario
	 *
	 * @return valor
	 * @access public
	 */
	function setIdUsuario($id_usuario) {

		$this->setSesionUsuarioId = $id_usuario;
	
	} // Fin del mètodo especificar_usuario
	function setSesionUsuario($valor) {

		$this->sesionUsuario = $valor;
	
	}

	function setTiempoExpiracion($valor) {

		$this->tiempoExpiracion = $valor;
	
	}

	function setPrefijoTablas($valor) {

		$this->prefijoTablas = $valor;
		$this->miSql->setPrefijoTablas ( $this->prefijoTablas );
	
	}

	/**
	 * @METHOD rescatar_valor_sesion
	 * @PARAM variable
	 * @PARAM usuario_aplicativo ??
	 *
	 * @return boolean
	 * @access public
	 */
	function getValorSesion($variable) {

		if (isset ( $_COOKIE ["aplicativo"] )) {
			$this->sesionId = $_COOKIE ["aplicativo"];
		} else {
			return FALSE;
		}
		
		$parametro ["sesionId"] = $this->sesionId;
		$parametro ["variable"] = $variable;
		$clausulaSQL = $this->miSql->getCadenaSql ( "buscarValorSesion", $parametro );
		
		$resultado = $this->miConexion->ejecutarAcceso ( $clausulaSQL, "busqueda" );
		
		if ($resultado) {
			$this->sesionExpiracion = $resultado [0] ["expiracion"];
			return $resultado [0] ["valor"];
		}
		return false;
	
	} // Fin del método rescatar_valor_sesion return FALSE;
	function getSesionId() {

		return $this->sesionId;
	
	}

	function getSesionUsuarioId() {

		return $this->sesionUsuarioId;
	
	}

	function getSesionNivel() {

		return $this->sesionNivel;
	
	}

	function getSesionExpiracion() {

		return $this->sesionExpiracion;
	
	}

} // Fin de la clase sesion

?>
