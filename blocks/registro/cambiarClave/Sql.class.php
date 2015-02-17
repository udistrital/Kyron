<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlCambiarClave extends sql {
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = Configurador::singleton ();
	}
	function cadena_sql($tipo, $variable = "") {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			case "buscarUsuario" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "id_usuario, ";
				$cadena_sql .= "nombre, ";
				$cadena_sql .= "apellido, ";
				$cadena_sql .= "correo, ";
				$cadena_sql .= "telefono, ";
				$cadena_sql .= "imagen, ";
				$cadena_sql .= "clave, ";
				$cadena_sql .= "tipo, ";
				$cadena_sql .= "estilo, ";
				$cadena_sql .= "idioma, ";
				$cadena_sql .= "estado ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo . "usuario ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_usuario = '" . trim ( $variable ) . "' ";
				break;
                            
			case "buscarUsuarioCenso" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "identificacion, ";
				$cadena_sql .= "clave ";
				$cadena_sql .= " FROM ".$prefijo . "censo ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "identificacion = '" . trim ( $variable ) . "' ";
				break;
			
			case "modificaClaveMySQL" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= $prefijo . "usuario ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "clave='" . $_REQUEST ['contrasena'] . "' ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_usuario = '" . $variable . "' ";
				break;
                            
			case "modificaClaveMySQLCenso" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= $prefijo . "censo ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "clave='" . $_REQUEST ['contrasena'] . "' ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "identificacion = '" . $variable . "' ";
				break;
			
			case "rescatarValorSesion" :
				$cadena_sql = "SELECT sesionid, variable, valor, expiracion FROM gearbox_valor_sesion";
				break;
			
			case "iniciarTransaccion" :
				$cadena_sql = "START TRANSACTION";
				break;
			
			case "finalizarTransaccion" :
				$cadena_sql = "COMMIT";
				break;
			
			case "cancelarTransaccion" :
				$cadena_sql = "ROLLBACK";
				break;
			
			case "eliminarTemp" :
				
				$cadena_sql = "DELETE ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo . "tempFormulario ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_sesion = '" . $variable . "' ";
				break;
			
			case "insertarTemp" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= $prefijo . "tempFormulario ";
				$cadena_sql .= "( ";
				$cadena_sql .= "id_sesion, ";
				$cadena_sql .= "formulario, ";
				$cadena_sql .= "campo, ";
				$cadena_sql .= "valor, ";
				$cadena_sql .= "fecha ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				
				foreach ( $_REQUEST as $clave => $valor ) {
					$cadena_sql .= "( ";
					$cadena_sql .= "'" . $idSesion . "', ";
					$cadena_sql .= "'" . $variable ['formulario'] . "', ";
					$cadena_sql .= "'" . $clave . "', ";
					$cadena_sql .= "'" . $valor . "', ";
					$cadena_sql .= "'" . $variable ['fecha'] . "' ";
					$cadena_sql .= "),";
				}
				
				$cadena_sql = substr ( $cadena_sql, 0, (strlen ( $cadena_sql ) - 1) );
				break;
			
			case "rescatarTemp" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "id_sesion, ";
				$cadena_sql .= "formulario, ";
				$cadena_sql .= "campo, ";
				$cadena_sql .= "valor, ";
				$cadena_sql .= "fecha ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo . "tempFormulario ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_sesion='" . $idSesion . "'";
				break;
		}
		return $cadena_sql;
	}
}

?>
