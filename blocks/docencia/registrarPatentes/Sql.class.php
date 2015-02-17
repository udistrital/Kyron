<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlregistrarPatentes extends sql {
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
			
			case "tipoPatente" :
				
				$cadena_sql = "SELECT id_patentes, nombre_patente ";
				$cadena_sql .= "FROM docencia.tipo_patente ";
				$cadena_sql .= "ORDER BY id_patentes";
				break;
                            
                        case "buscarProyectos" :

                            $cadena_sql = "SELECT codigo_proyecto, nombre_proyecto ";
                            $cadena_sql .= "FROM docencia.proyectocurricular ";
                            $cadena_sql .= " WHERE id_facultad = '".$variable."' ";
                            $cadena_sql .= "ORDER BY nombre_proyecto";
                            break;     
			
			case "tipo_titulo" :
				
				$cadena_sql = "SELECT id_nivel, descripcion_nivel ";
				$cadena_sql .= "FROM docencia.nivel_formacion ";
				$cadena_sql .= "ORDER BY id_nivel";
				break;
			
			case "universidad" :
				
				$cadena_sql = "SELECT id_universidad, nombre_universidad ";
				$cadena_sql .= "FROM docencia.universidades ";
				$cadena_sql .= "ORDER BY nombre_universidad";
				break;
			
			case "pais" :
				
				$cadena_sql = "SELECT paiscodigo, paisnombre ";
				$cadena_sql .= "FROM docencia.pais_kyron ";
				break;
			
			case "buscarNombreDocente" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "informacion_numeroidentificacion, ";
				$cadena_sql .= "informacion_numeroidentificacion || ' - ' || UPPER(informacion_nombres)|| ' ' ||UPPER(informacion_apellidos) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_informacion ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "informacion_estadoregistro = TRUE  ";
                                
                                if($variable != '')
                                    {
                                        if(is_numeric($variable))
                                        {
                                            $cadena_sql .= " AND  informacion_numeroidentificacion like '%".$variable."%'  ";
                                        }else
                                            {
                                                $cadena_sql .= " AND  ((UPPER(informacion_nombres) like '%".strtoupper($variable)."%') OR (UPPER(informacion_apellidos) like '%".strtoupper($variable)."%'))  ";
                                            }
                                    }
                                
				
				break;
			
			case "insertarPatente" :
				
				$cadena_sql = "INSERT INTO docencia.registrar_patentes( ";
				$cadena_sql .= "docente_patente, tipo_patente, titulo_patente, entidad_patente,";
				$cadena_sql .= "pais_patente, year_patente, concepto_patente, numregistro_patente, ";
				$cadena_sql .= "acta_patente, fecha_patente,numcaso_patente,puntaje_patente, detalledocencia) ";
				$cadena_sql .= " VALUES (" . $variable [0] . ",";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= " '" . $variable [2] . "',";
				$cadena_sql .= " '" . $variable [3] . "',";
				$cadena_sql .= " '" . $variable [4] . "',";
				$cadena_sql .= " '" . $variable [5] . "',";
				$cadena_sql .= " '" . $variable [6] . "',";
				$cadena_sql .= " '" . $variable [7] . "',";
				$cadena_sql .= " '" . $variable [8] . "',";
				$cadena_sql .= " '" . $variable [9] . "',";
				$cadena_sql .= " '" . $variable [10] . "',";
				$cadena_sql .= " '" . $variable [11] . "',";
				$cadena_sql .= " '" . $variable [12] . "')";
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
			
			case "registrarEvento" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= $prefijo . "logger( ";
				$cadena_sql .= "id_usuario, ";
				$cadena_sql .= "evento, ";
				$cadena_sql .= "fecha) ";
				$cadena_sql .= "VALUES( ";
				$cadena_sql .= $variable [0] . ", ";
				$cadena_sql .= "'" . $variable [1] . "', ";
				$cadena_sql .= "'" . time () . "') ";
				break;
			
			case "consultar" :
				
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "id_patente, titulo_patente, docente_patente, nombre_universidad,  ";
				$cadena_sql .= "paisnombre, year_patente, concepto_patente, numregistro_patente,    ";
				$cadena_sql .= "acta_patente, fecha_patente, puntaje_patente, nombre_patente, numcaso_patente,  ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.registrar_patentes ON docente_patente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.tipo_patente ON id_patentes = tipo_patente ";
				$cadena_sql .= "LEFT JOIN docencia.universidades ON id_universidad = entidad_patente ";
				$cadena_sql .= "LEFT JOIN docencia.pais_kyron ON paiscodigo = pais_patente  ";
				$cadena_sql .= "WHERE 1=1";
				break;
			
			case "consultarPatente" :
				
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "id_patente, titulo_patente, entidad_patente, pais_patente, year_patente,  ";
				$cadena_sql .= "concepto_patente, numregistro_patente, acta_patente, fecha_patente,   ";
				$cadena_sql .= "puntaje_patente, tipo_patente, numcaso_patente, docente_patente, detalledocencia  ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.registrar_patentes ON docente_patente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.tipo_patente ON id_patentes = tipo_patente ";
				$cadena_sql .= "LEFT JOIN docencia.universidades ON id_universidad = entidad_patente ";
				$cadena_sql .= "LEFT JOIN docencia.pais_kyron ON paiscodigo = pais_patente  ";
				$cadena_sql .= "WHERE id_patente=" . $variable;
				break;
			
			case "consultarPatentes" :
				
				$cadena_sql = "SELECT DISTINCT ";
				$cadena_sql .= "id_patente, docente_patente, titulo_patente, nombre_universidad, ";
				$cadena_sql .= "paisnombre, year_patente, concepto_patente, numregistro_patente, nombre_patente, puntaje_patente, ";
				$cadena_sql .= " informacion_nombres, informacion_apellidos, detalledocencia ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.registrar_patentes ON docente_patente = dependencia_iddocente ";
				$cadena_sql .= "LEFT JOIN docencia.pais_kyron ON paiscodigo = pais_patente  ";
				$cadena_sql .= "LEFT JOIN docencia.universidades ON id_universidad = entidad_patente ";
				$cadena_sql .= "JOIN docencia.tipo_patente ON id_patentes = tipo_patente ";
				$cadena_sql .= "WHERE 1=1";
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
			
			case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;
			
			case "actualizarPatente" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= "docencia.registrar_patentes ";
				$cadena_sql .= "SET ";
				$cadena_sql .= "titulo_patente = '" . $variable [1] . "', ";
				$cadena_sql .= "entidad_patente = '" . $variable [3] . "', ";
				$cadena_sql .= "pais_patente = '" . $variable [4] . "', ";
				$cadena_sql .= "year_patente = '" . $variable [5] . "', ";
				$cadena_sql .= "concepto_patente = '" . $variable [6] . "', ";
				$cadena_sql .= "numregistro_patente = '" . $variable [7] . "', ";
				$cadena_sql .= "acta_patente = '" . $variable [8] . "', ";
				$cadena_sql .= "fecha_patente = '" . $variable [10] . "', ";
				$cadena_sql .= "tipo_patente = '" . $variable [2] . "', ";
				$cadena_sql .= "numcaso_patente = '" . $variable [9] . "', ";
				$cadena_sql .= "puntaje_patente = '" . $variable [11] . "', ";
				$cadena_sql .= "detalledocencia = '" . $variable [12] . "' ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_patente ='" . $variable [0] . "' ";
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
