<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlregistrarMovilidadDocente extends sql {
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
			
						
			case "universidad" :
				
				$cadena_sql = "SELECT id_universidad, nombre_universidad ";
				$cadena_sql .= "FROM docencia.universidades ";
				$cadena_sql .= "ORDER BY nombre_universidad";
				break;
                            
			case "consultarUniversidad" :
				
				$cadena_sql = "SELECT id_universidad, nombre_universidad ";
				$cadena_sql .= "FROM docencia.universidades ";
				$cadena_sql .= "WHERE id_universidad = ".$variable;
				break;
			
                        case "facultades" :
				
				$cadena_sql = "SELECT codigo_facultad, nombre_facultad ";
				$cadena_sql .= "FROM docencia.facultades ";
				$cadena_sql .= "ORDER BY nombre_facultad";
				break;
			
                        case "consultarDependencia" :
				
				$cadena_sql = "SELECT codigo_facultad, nombre_facultad ";
				$cadena_sql .= "FROM docencia.facultades ";
				$cadena_sql .= "WHERE codigo_facultad = '".$variable."'";
				break;
			
						
			case "buscarNombreDocente" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "informacion_numeroidentificacion, ";
				$cadena_sql .= "UPPER(informacion_nombres)|| ' ' ||UPPER(informacion_apellidos) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_informacion ";
				
				if (is_numeric ( $variable )) {
					$cadena_sql .= "WHERE ";
					$cadena_sql .= "informacion_numeroidentificacion like '%" . strtoupper ( trim ( $variable ) ) . "%' ";
				} else {
					$cadena_sql .= "WHERE ";
					$cadena_sql .= "UPPER(informacion_nombres) like '%" . strtoupper ( trim ( $variable ) ) . "%' ";
					$cadena_sql .= "OR ";
					$cadena_sql .= "UPPER(informacion_apellidos) like '%" . strtoupper ( trim ( $variable ) ) . "%' ";
				}
				$cadena_sql .= "AND ";
				$cadena_sql .= "informacion_estadoregistro = TRUE  ";
				
				break;
			
				
			
			case "insertarMovilidad" :
				
				$cadena_sql = "INSERT INTO docencia.movilidad_docente( ";
				$cadena_sql .= "id_docente, tiquetesDep, inscripcionDep, viaticosDep, tiquetesEnt, inscripcionEnt, viaticosEnt, ruta_ponencia,nombre_ponencia,  ";
				$cadena_sql .= "	ruta_aceptacion,nombre_aceptacion) ";
				$cadena_sql .= " VALUES ('" . $variable [0] . "',";
				$cadena_sql .= " " . $variable [1] . ",";
				$cadena_sql .= " " . $variable [2] . ",";
				$cadena_sql .= " " . $variable [3] . ",";
				$cadena_sql .= " " . $variable [4] . ",";
				$cadena_sql .= " " . $variable [5] . ",";
				$cadena_sql .= " " . $variable [6] . ",";
				$cadena_sql .= " '" . $variable [7] . "',";
				$cadena_sql .= " '" . $variable [8] . "',";
				$cadena_sql .= " '" . $variable [9] . "',";
				$cadena_sql .= " '" . $variable [10] . "')";
				
				break;
                            
                        case "registrarEvento" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= $prefijo . "logger( ";
				$cadena_sql .= "id_usuario, ";
				$cadena_sql .= "evento, ";
				$cadena_sql .= "fecha) ";
				$cadena_sql .= "VALUES( ";
				$cadena_sql .= $variable[0].", ";
				$cadena_sql .= "'" . $variable[1] . "', ";
				$cadena_sql .= "'" . time () . "') ";
			
                                break;     
			
			case "facultad" :
				
				$cadena_sql = "SELECT codigo_facultad, nombre_facultad ";
				$cadena_sql .= "FROM docencia.facultades ";
				$cadena_sql .= "ORDER BY nombre_facultad";
				break;
			
			case "proyectos" :
				
				$cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
				$cadena_sql .= "FROM docencia.proyectocurricular ";
				$cadena_sql .= "ORDER BY nombre_proyecto";
				break;
			
			case "categoria" :
				
				$cadena_sql = "SELECT item_parametro, item_nombre ";
				$cadena_sql .= "FROM docencia.item_parametro ";
				$cadena_sql .= "WHERE item_idparametro = 1";
				break;
	
			
			case "consultar" :
				
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "id_movilidad, id_docente, tiquetesdep, inscripciondep, viaticosdep, tiquetesent, inscripcionent, viaticosent, ruta_ponencia, ";
				$cadena_sql .= "nombre_ponencia, ruta_aceptacion, nombre_aceptacion, ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= " JOIN docencia.movilidad_docente ON id_docente = dependencia_iddocente ";
				$cadena_sql .= " WHERE 1=1";
				if ($variable [0] != '') {
					$cadena_sql .= " AND dependencia_iddocente = '" . $variable [0] . "'";
				}
				if ($variable [1] != '') {
					$cadena_sql .= " AND dependencia_facultad = '" . $variable [1] . "'";
				}
				if ($variable [2] != '') {
					$cadena_sql .= " AND dependencia_proyectocurricular = '" . $variable [2] . "'";
				}
				
				break;
			
			case "consultarMovilidad" :
				
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "id_movilidad, id_docente, tiquetesdep, inscripciondep, viaticosdep, tiquetesent, inscripcionent, viaticosent, ruta_ponencia, ";
				$cadena_sql .= "nombre_ponencia, ruta_aceptacion, nombre_aceptacion ";
				$cadena_sql .= "FROM docencia.movilidad_docente ";
				$cadena_sql .= " WHERE id_movilidad = ".$variable;
				
				break;
			
			case "actualizarMovilidad" :
				
				$cadena_sql = "UPDATE docencia.movilidad_docente ";
				$cadena_sql .= " SET tiquetesdep = ".$variable[2].", ";
				$cadena_sql .= " inscripciondep = ".$variable[3].", ";
				$cadena_sql .= " viaticosdep = ".$variable[4].", ";
				$cadena_sql .= " tiquetesent = ".$variable[5].", ";
				$cadena_sql .= " inscripcionent = ".$variable[6].", ";
				$cadena_sql .= " viaticosent = ".$variable[7]." ";
                                
                                if($variable[8] != "" && $variable[9] != "")
                                    {
                                        $cadena_sql .= ", ruta_ponencia = '".$variable[8]."', ";
                                        $cadena_sql .= " nombre_ponencia = '".$variable[9]."' ";
                                    }
                                    
                                if($variable[10] != "" && $variable[11] != "")
                                    {
                                        $cadena_sql .= ", ruta_aceptacion = '".$variable[10]."', ";
                                        $cadena_sql .= " nombre_aceptacion = '".$variable[11]."' ";
                                    }
                                    
				$cadena_sql .= " WHERE id_movilidad = ".$variable[0];
				
				break;
			
			/**
			 * Clausulas genéricas.
			 * se espera que estén en todos los formularios
			 * que utilicen esta plantilla
			 */
			
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
