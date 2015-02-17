<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlregistrarInterpretaciones extends sql {
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
			
			case "consultarDocente" :
				
				$cadena_sql = "SELECT informacion_numeroidentificacion, ";
				$cadena_sql .= "(informacion_nombres || ' ' || informacion_apellidos) AS Nombres ";
				$cadena_sql .= "FROM docencia.docente_informacion ";
				$cadena_sql .= "WHERE informacion_numeroidentificacion = '" . $variable . "'";
				break;
			
			case "buscarNombreDocente" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "informacion_numeroidentificacion, ";
				$cadena_sql .= "informacion_numeroidentificacion || ' - ' || UPPER(informacion_nombres)|| ' ' ||UPPER(informacion_apellidos) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= "docencia.docente_informacion ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "informacion_estadoregistro = TRUE  ";
				
				break;
			
			case "insertarIntepretacion" :
				
				$cadena_sql = "INSERT INTO docencia.registrar_interpretaciones( ";
				$cadena_sql .= "id_docente, titulo_interpretacion, entidad_interpretacion,  ";
				$cadena_sql .= "numpres_interpretacion, fecha_intepretacion, autor_interpretacion, ";
				$cadena_sql .= "numacta_interpretacion, fechacta_interpretacion, numcaso_interpretacion, ";
				$cadena_sql .= "puntaje_interpretacion ) ";
				$cadena_sql .= " VALUES (" . $variable [0] . ",";
				$cadena_sql .= " '" . $variable [1] . "',";
				$cadena_sql .= " '" . $variable [2] . "',";
				$cadena_sql .= " '" . $variable [3] . "',";
				$cadena_sql .= " '" . $variable [4] . "',";
				$cadena_sql .= " '" . $variable [5] . "',";
				$cadena_sql .= " '" . $variable [6] . "',";
				$cadena_sql .= " '" . $variable [7] . "',";
				$cadena_sql .= " '" . $variable [8] . "',";
				$cadena_sql .= " '" . $variable [9] . "')";
				
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
			
			case "consultarInterpretacionDocenteModificar" :
				
				$cadena_sql = " SELECT id_docente, titulo_interpretacion, entidad_interpretacion,";
				$cadena_sql .= "numpres_interpretacion, fecha_intepretacion, autor_interpretacion, ";
				$cadena_sql .= "numacta_interpretacion, fechacta_interpretacion, numcaso_interpretacion,puntaje_interpretacion  ";
				$cadena_sql .= "FROM docencia.registrar_interpretaciones ";
				$cadena_sql .= "WHERE id_interpretacion ='" . $variable . "'";
				
				break;
			
			case "consultarInterpretaciones" :
				
				$cadena_sql = "SELECT DISTINCT id_docente, autor_interpretacion, ";
				$cadena_sql .= " titulo_interpretacion,nombre_universidad, numpres_interpretacion, ";
				$cadena_sql .= "fecha_intepretacion, numacta_interpretacion, fechacta_interpretacion, ";
				$cadena_sql .= "numcaso_interpretacion, puntaje_interpretacion,";
				$cadena_sql .= " informacion_nombres, informacion_apellidos, id_interpretacion ";
				$cadena_sql .= "FROM docencia.dependencia_docente ";
				$cadena_sql .= " JOIN docencia.docente_informacion ON informacion_numeroidentificacion = dependencia_iddocente ";
				$cadena_sql .= "JOIN  docencia.registrar_interpretaciones ON id_docente = dependencia_iddocente ";
				$cadena_sql .= "JOIN docencia.universidades ON id_universidad = entidad_interpretacion ";
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
			
			// UPDATE docencia.registrar_interpretaciones
			// SET id_interpretacion=?, id_docente=?, titulo_interpretacion=?, entidad_interpretacion=?,
			// numpres_interpretacion=?, fecha_intepretacion=?, autor_interpretacion=?,
			// numacta_interpretacion=?, fechacta_interpretacion=?, numcaso_interpretacion=?,
			// puntaje_interpretacion=?
			// WHERE <condition>;
			
				

				$arregloDatos = array (
						$_REQUEST ['idInterpretacion'],
						$_REQUEST ['tituloInterpretacion'],
						$_REQUEST ['entidad'],
						$_REQUEST ['numPresentacion'],
						$_REQUEST ['fechPresentacion'],
						$_REQUEST ['autorPresentacion'],
						$_REQUEST ['numeActa'],
						$_REQUEST ['fechaActa'],
						$_REQUEST ['numeCaso'],
						$_REQUEST ['puntaje']
				);
				
			case "actualizarIntepretacion" :
				$cadena_sql = "UPDATE docencia.registrar_interpretaciones ";
				$cadena_sql .= "SET titulo_interpretacion='" . $variable [1] . "',";
				$cadena_sql .= "entidad_interpretacion='" . $variable [2] . "',";
				$cadena_sql .= "numpres_interpretacion='" . $variable [3] . "',";
				$cadena_sql .= "fecha_intepretacion='" . $variable [4] . "',";
				$cadena_sql .= "autor_interpretacion='" . $variable [5] . "',";
				$cadena_sql .= "numacta_interpretacion='" . $variable [6] . "',";
				$cadena_sql .= "fechacta_interpretacion='" . $variable [7] . "',";
				$cadena_sql .= "numcaso_interpretacion='" . $variable [8] . "',";
				$cadena_sql .= "puntaje_interpretacion='" . $variable [9] . "' ";
				$cadena_sql .= "WHERE id_interpretacion='" . $variable [0] . "'";
			
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
